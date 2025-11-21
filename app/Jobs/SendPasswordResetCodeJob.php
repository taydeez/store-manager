<?php

namespace App\Jobs;

use App\Mail\PasswordResetCodeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetCodeJob implements ShouldQueue
{
    use Queueable;

    public $email;
    public $code;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $code)
    {
        $this->email = $email;
        $this->code = $code;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new PasswordResetCodeMail($this->code));
    }
}
