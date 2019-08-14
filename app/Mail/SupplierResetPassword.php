<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SupplierResetPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $token;
    public $userInfo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $userInfomation) {
        $this->token = $token;
        $this->userInfo = $userInfomation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        return $this->view('email.forgot_password', compact('token','userInfo'));
    }
}