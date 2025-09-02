<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobApplicationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $applicationData;
    public $jobListing;

    public function __construct($applicationData, $jobListing)
    {
        $this->applicationData = $applicationData;
        $this->jobListing = $jobListing;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application Received - ' . $this->jobListing->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.job-application-confirmation',
        );
    }
}