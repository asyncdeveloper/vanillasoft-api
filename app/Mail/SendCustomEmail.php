<?php

namespace App\Mail;

use App\Models\CustomEmail;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCustomEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $customEmail;

    /**
     * Create a new message instance.
     * @param CustomEmail $customEmail
     */
    public function __construct(CustomEmail $customEmail)
    {
        $this->customEmail = $customEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->markdown('emails.custom')
            ->subject($this->customEmail->subject)
            ->with('body', $this->customEmail->body);

        foreach($this->customEmail->attachments as $emailAttachment){
            $mime =  [ 'mime' =>  MimeType::fromFilename($emailAttachment['name']) ];
            $mail->attachData(base64_decode($emailAttachment['content']), $emailAttachment['name'], $mime);
        }

        return $mail;
    }
}
