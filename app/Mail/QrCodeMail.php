<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $qrCodePath;

    /**
     * Create a new message instance.
     */
    public function __construct($qrCodeData)
    {
        // Generate and store the QR code image
        $filename = 'qrcode_' . time() . '.png';
        $qrCodeImage = QrCode::format('png')->size(300)->generate($qrCodeData);

        // Save QR code in the storage/app/public/qrcodes folder
        Storage::disk('public')->put('qrcodes/' . $filename, $qrCodeImage);

        // Path to the QR code
        $this->qrCodePath = storage_path('app/public/qrcodes/' . $filename);

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Qr Code Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.qrCodeMail',
            with: ["qrCodePath" => $this->qrCodePath]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->qrCodePath)
                ->as('qrcode.png')
                ->withMime('image/png'),
        ];
    }
}
