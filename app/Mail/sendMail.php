<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->from('ngoclan2002@gmail.com', 'From Lan')
        ->subject('yêu cầu cấp lại mật khẩu từ shop bánh')
        ->replyTo('ngoclan2002@gmail.com', 'Ngoc Lan')
        ->view('emails.interfaceEmail',['sentData' => $this->sentData]);
    }
}
