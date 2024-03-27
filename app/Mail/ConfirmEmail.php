<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
class ConfirmEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // Define public variable to hold user data
    public $verificationCode;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $verificationCode) 
    {
        $this->user = $user; 
        $this->verificationCode = $verificationCode; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirm Email')
                    ->view('confirm');
    }
}