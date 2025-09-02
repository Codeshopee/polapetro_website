<?php

namespace App\Jobs;

use App\Models\ContactMessage;
use App\Mail\ContactFormMail;
use App\Mail\ContactFormReply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessContactForm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contactData;

    public function __construct(array $contactData)
    {
        $this->contactData = $contactData;
    }

    public function handle()
    {
        // Save to database
        $contact = ContactMessage::create($this->contactData);

        // Send email to admin
        Mail::to(config('mail.contact_email'))
            ->send(new ContactFormMail($this->contactData));

        // Send auto-reply to user
        Mail::to($this->contactData['email'])
            ->send(new ContactFormReply($this->contactData));
    }
}