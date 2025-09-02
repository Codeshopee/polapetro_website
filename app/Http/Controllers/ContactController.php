<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Display contact form page
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Show contact form (alternative method name)
     */
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        // Spam protection - honeypot field
        if ($request->filled('website')) {
            Log::warning('Spam attempt detected', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'honeypot_value' => $request->input('website')
            ]);

            return redirect()->back()->with('error', 'Your submission could not be processed. Please try again.');
        }

        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.\']+$/u',
            'email' => 'required|email:rfc,dns|max:255',
            'subject' => 'required|in:Customer,Supplier',
            'message' => 'required|string|max:5000|min:10',
            'website' => 'nullable', // honeypot field
        ]);

        // Konfigurasi email berdasarkan kategori
        $emailConfig = $this->getEmailConfiguration($validatedData['subject']);

        // Debug log untuk melihat konfigurasi email
        Log::info('Email Configuration Debug', [
            'subject_category' => $validatedData['subject'],
            'email_config' => $emailConfig,
            'form_data' => [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'subject' => $validatedData['subject']
            ]
        ]);

        try {
            // Pastikan ada email tujuan
            if (empty($emailConfig['to'])) {
                throw new \Exception('No recipient email configured for category: ' . $validatedData['subject']);
            }

            // Kirim email langsung tanpa CC/BCC
            Mail::to($emailConfig['to'])->send(new ContactMail($validatedData));

            // Log untuk tracking
            Log::info('Contact form submitted successfully', [
                'category' => $validatedData['subject'],
                'sender_email' => $validatedData['email'],
                'recipient' => $emailConfig['to'],
                'timestamp' => now()
            ]);

            return redirect()->back()->with('success', 'Pesan berhasil dikirim ke ' . ($validatedData['subject'] === 'Customer' ? 'Customer Service' : 'Supplier Relations') . '!');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Failed to send contact email', [
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_line' => $e->getLine(),
                'category' => $validatedData['subject'],
                'sender_email' => $validatedData['email'],
                'email_config' => $emailConfig,
                'timestamp' => now()
            ]);

            // Coba kirim ke email backup
            $this->sendToBackup($validatedData, $e);

            return redirect()->back()->with('error', 'Gagal mengirim pesan ke ' . ($validatedData['subject'] === 'Customer' ? 'Customer Service' : 'Supplier Relations') . '. Error: ' . $e->getMessage());
        }
    }

    /**
     * Konfigurasi email berdasarkan kategori
     */
    private function getEmailConfiguration($category)
    {
        switch ($category) {
            case 'Customer':
                return [
                    'to' => env('CUSTOMER_EMAIL', 'juandijuan644@gmail.com')
                ];

            case 'Supplier':
                return [
                    'to' => env('SUPPLIER_EMAIL', 'iwalrasyidin@gmail.com')
                ];

            default:
                return [
                    'to' => env('GENERAL_INQUIRY_EMAIL', 'info@yourdomain.com')
                ];
        }
    }

    /**
     * Get display name untuk kategori
     */
    private function getCategoryDisplayName($category)
    {
        $displayNames = [
            'Customer' => 'Customer Service',
            'Supplier' => 'Supplier Relations',
            'General' => 'General Inquiry',
            'HRD' => 'Human Resources',
            'Sales' => 'Sales Team',
            'Finance' => 'Finance Department',
            'Technical' => 'Technical Support'
        ];

        return $displayNames[$category] ?? $category;
    }

    /**
     * Parse multiple emails dari string
     */
    private function parseEmails($emailString)
    {
        if (empty($emailString)) {
            return [];
        }

        // Support untuk multiple emails separated by comma atau semicolon
        $emails = array_map('trim', preg_split('/[,;]/', $emailString));

        // Filter email yang valid
        return array_filter($emails, function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        });
    }

    /**
     * Kirim ke email backup jika email utama gagal
     */
    private function sendToBackup($data, $originalException)
    {
        try {
            $backupEmail = env('BACKUP_EMAIL');
            $adminEmail = env('ADMIN_EMAIL');

            if ($backupEmail) {
                // Tambahkan info error ke data
                $data['original_error'] = $originalException->getMessage();
                $data['is_backup'] = true;
                $data['failed_category'] = $data['subject'];

                Mail::to($backupEmail)
                    ->send(new ContactMail($data));

                Log::info('Email sent to backup successfully', [
                    'backup_email' => $backupEmail,
                    'failed_category' => $data['subject'],
                    'original_error' => $originalException->getMessage()
                ]);
            }
        } catch (\Exception $backupException) {
            Log::critical('Backup email also failed', [
                'backup_error' => $backupException->getMessage(),
                'original_error' => $originalException->getMessage(),
                'category' => $data['subject']
            ]);
        }
    }

    /**
     * Method untuk test email configuration (untuk debugging)
     */
    public function testEmailConfig()
    {
        $categories = ['Customer', 'Supplier', 'General', 'HRD', 'Sales', 'Finance', 'Technical'];
        $configs = [];

        foreach ($categories as $category) {
            $configs[$category] = $this->getEmailConfiguration($category);
        }

        return response()->json([
            'email_configurations' => $configs,
            'environment_variables' => [
                'CUSTOMER_EMAIL' => env('CUSTOMER_EMAIL'),
                'SUPPLIER_EMAIL' => env('SUPPLIER_EMAIL'),
                'GENERAL_INQUIRY_EMAIL' => env('GENERAL_INQUIRY_EMAIL'),
                'HRD_EMAIL' => env('HRD_EMAIL'),
                'SALES_EMAIL' => env('SALES_EMAIL'),
                'FINANCE_EMAIL' => env('FINANCE_EMAIL'),
                'TECHNICAL_EMAIL' => env('TECHNICAL_EMAIL'),
                'BACKUP_EMAIL' => env('BACKUP_EMAIL'),
                'ADMIN_EMAIL' => env('ADMIN_EMAIL'),
                'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS')
            ]
        ]);
    }

    /**
     * Method debugging untuk test konfigurasi email
     */
    public function debugEmail()
    {
        $customerConfig = $this->getEmailConfiguration('Customer');
        $supplierConfig = $this->getEmailConfiguration('Supplier');

        $debug = [
            'Environment Variables' => [
                'CUSTOMER_EMAIL' => env('CUSTOMER_EMAIL'),
                'SUPPLIER_EMAIL' => env('SUPPLIER_EMAIL'),
                'MAIL_HOST' => env('MAIL_HOST'),
                'MAIL_PORT' => env('MAIL_PORT'),
                'MAIL_USERNAME' => env('MAIL_USERNAME'),
                'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
                'BACKUP_EMAIL' => env('BACKUP_EMAIL'),
                'ADMIN_EMAIL' => env('ADMIN_EMAIL')
            ],
            'Email Configurations' => [
                'Customer' => $customerConfig,
                'Supplier' => $supplierConfig
            ],
            'Laravel Config' => [
                'mail_driver' => config('mail.default'),
                'mail_host' => config('mail.mailers.smtp.host'),
                'mail_port' => config('mail.mailers.smtp.port'),
                'mail_from' => config('mail.from.address')
            ]
        ];

        return response()->json($debug, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Test kirim email untuk debugging
     */
    public function testSendEmail(Request $request)
    {
        $category = $request->get('category', 'Customer');

        $testData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => $category,
            'message' => 'This is a test message from ContactController debug function.'
        ];

        try {
            $emailConfig = $this->getEmailConfiguration($category);

            Mail::to($emailConfig['to'])->send(new ContactMail($testData));

            return response()->json([
                'status' => 'success',
                'message' => 'Test email sent successfully',
                'category' => $category,
                'recipient' => $emailConfig['to'],
                'config' => $emailConfig
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'category' => $category,
                'config' => $emailConfig ?? null,
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    /**
     * Kirim notifikasi ke admin (optional method)
     */
    public function notifyAdmin($data, $status = 'success')
    {
        try {
            $adminEmail = env('ADMIN_EMAIL');
            $notificationEmail = env('NOTIFICATION_EMAIL');

            if ($adminEmail || $notificationEmail) {
                $recipients = array_filter([$adminEmail, $notificationEmail]);

                $notificationData = array_merge($data, [
                    'status' => $status,
                    'timestamp' => now(),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'category_display' => $this->getCategoryDisplayName($data['subject'])
                ]);

                Mail::to($recipients)->send(new ContactMail($notificationData, 'admin_notification'));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send admin notification', [
                'error' => $e->getMessage(),
                'category' => $data['subject'] ?? 'unknown'
            ]);
        }
    }
}