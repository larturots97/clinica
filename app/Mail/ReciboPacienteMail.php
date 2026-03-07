<?php

namespace App\Mail;

use App\Models\Factura;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class ReciboPacienteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Factura $factura) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu recibo de pago — ' . $this->factura->folio,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.recibo',
        );
    }

    public function attachments(): array
    {
        $factura = $this->factura;
        $pdf = Pdf::loadView('medico.pagos.pdf', compact('factura'));

        return [
            Attachment::fromData(
                fn () => $pdf->output(),
                'recibo-' . $this->factura->folio . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
