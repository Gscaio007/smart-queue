<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CampaignEmail extends Mailable
{
    use Queueable, SerializesModels;

    // 1. Declaramos as variáveis públicas que a View HTML vai usar
    public $subject;
    public $content;

    /**
     * 2. O Construtor recebe os dados que o seu Job vai passar para ele
     */
    public function __construct($subject, $content)
    {
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * 3. Define o Envelope do e-mail (Assunto, remetente, etc.)
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject, // Define o assunto dinamicamente
        );
    }

    /**
     * 4. Define qual arquivo HTML (View) vai renderizar o corpo do e-mail
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.campaign', // Vai procurar o arquivo em resources/views/emails/campaign.blade.php
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}