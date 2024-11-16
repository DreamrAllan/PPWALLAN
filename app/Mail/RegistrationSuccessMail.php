<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Registration Successful')
                    ->view('emails.registration_success')
                    ->with([
                        'name' => $this->user->name,
                        'email' => $this->user->email,
                        'registration_date' => now()->format('Y-m-d H:i:s'),
                    ]);
    }
}
