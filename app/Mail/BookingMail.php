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

class BookingMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $bookingData;
//    protected $qrCodePath;


    /**
     * Create a new message instance.
     */
    public function __construct($bookingData)
    {
        $this->bookingData = $bookingData;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.bookingMail',
            with: [
                "booking_id" => $this->bookingData->id,
                "booking_check_in" => $this->bookingData->check_in,
                "booking_check_out" => $this->bookingData->check_out,
                "booking_price" => $this->bookingData->total_price_in_cent/100 . ' €',
                "booking_number_person" => $this->bookingData->number_of_persons,
                "services" => $this->bookingData->services,

                "user_lastname" => $this->bookingData->user->lastname,
                "user_firstname" => $this->bookingData->user->firstname,
                "user_address" => $this->bookingData->user->address,
                "user_postal_code" => $this->bookingData->user->postal_code,
                "user_city" => $this->bookingData->user->city,
                "user_phone" => $this->bookingData->user->phone,
                "user_email" => $this->bookingData->user->email,
            ]
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
//            Attachment::fromPath($this->qrCodePath)
//                ->as('qrcode.png')
//                ->withMime('image/png'),
        ];
    }
}
