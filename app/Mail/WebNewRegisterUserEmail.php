<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WebNewRegisterUserEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newWebRegisterUser')->subject(trans('api/api_v1/email.register_email_subject_line'))->to($this->user->email)->with(['user' => $this->user, 'password' => $this->password]);
    }
}
