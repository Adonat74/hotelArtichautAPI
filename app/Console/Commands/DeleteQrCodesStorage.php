<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteQrCodesStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-qr-codes-storage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the qr codes storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Storage::disk('public')->delete(Storage::disk('public')->files('qrcodes'));
    }
}
