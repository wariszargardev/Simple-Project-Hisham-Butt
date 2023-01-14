<?php

namespace App\Jobs;

use App\Mail\ForgotPasswordMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email, $token;

    public function __construct($email, $token)
    {
        $this->email= $email;
        $this->token= $token;
    }

    public function handle()
    {
        try {
            \Mail::to($this->email)->send(new ForgotPasswordMail($this->token));
        }
        catch (\Exception $exception){
            \Log::error("Forgot password email not send to ". $this->email);
        }

    }
}
