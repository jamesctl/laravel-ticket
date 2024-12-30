<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $otp;

    /**
     * Tạo đối tượng gửi email
     *
     * @param string $subject
     * @param string $otp
     * @return void
     */
    public function __construct($subject, $otp)
    {
        $this->subject = $subject;  
        $this->otp = $otp;          
    }

    /**
     * 
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.send-otp')
                    ->subject($this->subject)
                    ->with([
                        'otp' => $this->otp,
                    ]);
    }
}
