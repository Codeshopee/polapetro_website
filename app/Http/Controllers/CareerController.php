<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\JobListing; // pastikan model ini ada

class CareerController extends Controller
{
    public function index()
    {
        // Ambil semua jobs untuk filter dropdown
        $allJobs = JobListing::all();

        // Ambil jobs dengan pagination (3 per halaman)
        $jobs = JobListing::latest()->paginate(3);

        // Hitung total jobs untuk info
        $totalJobs = JobListing::count();

        // Kirim ke view careers.blade.php
        return view('careers', compact('jobs', 'allJobs', 'totalJobs'));
    }

    public function show($slug)
    {
        // Method untuk menampilkan detail job
        try {
            $jobListing = JobListing::where('slug', $slug)->firstOrFail();
            return view('careers.show', compact('jobListing'));
        } catch (\Exception $e) {
            // Fallback jika model tidak ada atau error
            $jobListing = (object) [
                'slug' => $slug,
                'title' => 'Job Position',
                'department' => 'General',
                'description' => 'Job description will be available soon.'
            ];
            return view('careers.show', compact('jobListing'));
        }
    }

    public function submitApplication(Request $request, $slug)
    {
        Log::info('=== FORM SUBMITTED ===');
        Log::info('Slug: ' . $slug);
        Log::info('Data received:', $request->all());

        try {
            // Validasi
            $validated = $request->validate([
                'job_category' => 'required|string',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'date_of_birth' => 'required|date',
                'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
                'cover_letter' => 'nullable|string|max:2000',
            ]);

            Log::info('Validation passed');

            // Ambil data job listing
            try {
                $jobListing = JobListing::where('slug', $slug)->first();
                $jobTitle = $jobListing ? $jobListing->title : $slug;
            } catch (\Exception $e) {
                $jobTitle = $slug; // fallback
            }

            // Simpan resume
            $resumePath = null;
            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('resumes', 'local');
                Log::info('Resume saved to: ' . $resumePath);
            }

            // Kirim email
            $emailContent = "
New Job Application for: {$jobTitle}

Name: {$validated['name']}
Email: {$validated['email']}
Phone: {$validated['phone']}
Category: {$validated['job_category']}
Date of Birth: {$validated['date_of_birth']}

Cover Letter:
{$validated['cover_letter']}
            ";

            Mail::raw($emailContent, function ($message) use ($validated, $jobTitle, $resumePath) {
                $message->to(env('ADMIN_EMAIL'))
                    ->subject('New Job Application - ' . $validated['name'] . ' for ' . $jobTitle);

                if ($resumePath && file_exists(storage_path('app/' . $resumePath))) {
                    $message->attach(storage_path('app/' . $resumePath), [
                        'as' => 'Resume_' . $validated['name'] . '.pdf'
                    ]);
                }
            });

            Log::info('Email sent successfully to: ' . env('ADMIN_EMAIL'));

            return redirect()->back()->with('success', 'Your application has been submitted successfully! We will contact you soon.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', $e->errors());
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Application submission error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, there was an error submitting your application. Please try again. Error: ' . $e->getMessage());
        }
    }
}
