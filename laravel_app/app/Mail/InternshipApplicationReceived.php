<?php

namespace App\Mail;

use App\Models\InternshipApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InternshipApplicationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public InternshipApplication $application)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva postulación de pasantía: '.$this->application->full_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.internship-application-received',
            with: ['application' => $this->application],
        );
    }
}
