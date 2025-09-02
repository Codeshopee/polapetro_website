<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactData;

    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pesan Kontak Baru dari ' . $this->contactData['subject'],
            replyTo: $this->contactData['email'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            with: ['contactData' => $this->contactData]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}