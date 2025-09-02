<?php
// app/Http/Controllers/JobApplicationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\JobApplicationMail;
use App\Mail\JobApplicationConfirmationMail;
use App\Models\JobApplication;
use App\Models\JobListing;
use Illuminate\Support\Facades\Log;

class JobApplicationController extends Controller
{
    public function store(Request $request, $slug)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB
            'cover_letter' => 'nullable|string|max:1000',
            'privacy_consent' => 'required|accepted',
        ]);

        try {
            // Ambil job listing berdasarkan slug
            $jobListing = JobListing::where('slug', $slug)->firstOrFail();

            // Upload resume
            $resumePath = null;
            if ($request->hasFile('resume')) {
                $file = $request->file('resume');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $resumePath = $file->storeAs('resumes', $fileName, 'public');
            }

            // Simpan data aplikasi ke database
            $jobApplication = JobApplication::create([
                'job_listing_id' => $jobListing->id,
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'date_of_birth' => $validatedData['date_of_birth'],
                'resume_path' => $resumePath,
                'cover_letter' => $validatedData['cover_letter'],
                'status' => 'pending',
                'applied_at' => now(),
            ]);

            // Log untuk debugging
            Log::info('Job application created', [
                'application_id' => $jobApplication->id,
                'applicant_email' => $validatedData['email'],
                'job_title' => $jobListing->title
            ]);

            // Kirim email ke HRD
            $hrdEmail = config('mail.hrd_email', 'kamnyet4077@gmail.com');

            Mail::to($hrdEmail)->send(new JobApplicationMail([
                'jobApplication' => $jobApplication,
                'jobListing' => $jobListing,
                'resumePath' => storage_path('app/public/' . $resumePath),
            ]));

            // Kirim email konfirmasi ke pelamar
            Mail::to($validatedData['email'])->send(new JobApplicationConfirmationMail([
                'applicantName' => $validatedData['name'],
                'jobTitle' => $jobListing->title,
                'applicationId' => $jobApplication->id,
            ]));

            Log::info('Emails sent successfully', [
                'application_id' => $jobApplication->id,
                'hrd_email' => $hrdEmail,
                'applicant_email' => $validatedData['email']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully! We will review your application and get back to you soon.',
                'application_id' => $jobApplication->id
            ]);

        } catch (\Exception $e) {
            Log::error('Job application submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
    }
}