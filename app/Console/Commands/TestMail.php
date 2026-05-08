<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    protected $signature = 'mail:test';
    protected $description = 'Send test email';

    public function handle()
    {
        Mail::raw('This is a test email from Laravel 12', function ($message) {
            $message->to('hammoudahmad166@gmail.com')
                ->subject('Laravel Mail Test');
        });

        $this->info('Email sent. Check Mailtrap Email Sandbox.');
    }
}
