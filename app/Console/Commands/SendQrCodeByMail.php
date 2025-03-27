<?php

namespace App\Console\Commands;

use App\Mail\QrCodeMail;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendQrCodeByMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:send-qr-code-by-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Check check_in date of all bookings and send email with qr code when it's today";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $bookings = Booking::where('check_in', '=', $today)
            ->with('user')
            ->get();

        foreach ($bookings as $booking) {
            $user = $booking->user;

            Mail::to($user->email)->send(new QrCodeMail(
                $user
            ));
        }
    }
}
