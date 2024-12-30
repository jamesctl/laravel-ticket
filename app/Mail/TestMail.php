<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\UploadedFile;


class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $name;
    public $messageContent;
    public $attachment;

    /**
     * 
     *
     * @param string $name
     * @param string $email
     * @return void
     */
    public function __construct($subject ,$name, $messageContent, $attachment = null)
    {
        $this->subject = $subject;
        $this->name = $name;
        $this->messageContent = $messageContent;
        $this->attachment = $attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('emails.ticket-support')
                    ->subject($this->subject)
                    ->with([
                        'name' => $this->name,
                        'message' => $this->messageContent,
                    ]);

        if (isset($this->attachment) && count($this->attachment) > 0) {
            foreach ($this->attachment as $file) {
                // Ensure it's an instance of UploadedFile before attaching
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $email->attach($file->getRealPath(), [
                        'as' => $file->getClientOriginalName(),
                        'mime' => $file->getMimeType(),
                    ]);
                }
            }
        }

        return $email;
    }
}
