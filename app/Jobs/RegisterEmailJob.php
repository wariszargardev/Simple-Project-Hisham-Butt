<?php

namespace App\Jobs;

use App\Mail\RegisterEmailMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RegisterEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    public function __construct($user)
    {
        $this->user= $user;
    }

    public function handle()
    {
        try {
            \Mail::to( $this->user->email)->send(new RegisterEmailMail($this->user));
        }catch (\Exception $exception){
            \Log::alert("Register email not send to ". $this->user->email);
        }
    }
}
