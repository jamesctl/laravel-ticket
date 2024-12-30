<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\UploadedFile;


class SendCustomerInfoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $email;
    public $name;
    public $password;
    public $messageContent;
    
    /**
     * 
     *
     * @param string $name
     * @param string $email
     * @return void
     */
    public function __construct($subject, $email ,$name, $password, $messageContent = null)
    {
        $this->subject = $subject;
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->messageContent = $messageContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('emails.welcome-email')
                    ->subject($this->subject)
                    ->with([
                        'name' => $this->name,
                        'email' => $this->email,
                        'message' => $this->messageContent,
                        'password' => $this->password,
                    ]);

        return $email;
    }
}
