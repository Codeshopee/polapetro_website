<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class JobApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $applicationData;
    public $resumePath;
    public $jobListing;

    public function __construct($applicationData, $resumePath, $jobListing)
    {
        $this->applicationData = $applicationData;
        $this->resumePath = $resumePath;
        $this->jobListing = $jobListing;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Job Application - ' . $this->jobListing->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.job-application',
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        if ($this->resumePath && file_exists(storage_path('app/' . $this->resumePath))) {
            $attachments[] = Attachment::fromStorage($this->resumePath)
                ->as('Resume_' . $this->applicationData['name'] . '.pdf');
        }

        return $attachments;
    }
}