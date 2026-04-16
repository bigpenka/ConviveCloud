<?php

namespace App\Mail;

use App\Models\Incident;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IncidenteCerradoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $incident;

    public function __construct(Incident $incident)
    {
        $this->incident = $incident;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notificación Oficial: Cierre de Incidente - ConviveCloud',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.incidente_cerrado',
        );
    }
}