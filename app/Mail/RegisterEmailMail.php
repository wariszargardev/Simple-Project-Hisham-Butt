<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisterEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user= $user;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Registration Email',
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'emails.register-email',
        );
    }

    public function attachments()
    {
        return [];
    }
}
