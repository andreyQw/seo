<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    protected $view_mail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Array $data, $view_mail)
    {
        $this->data = $data;
        $this->view_mail = $view_mail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(empty($this->data['subject'])){
            $this->data['subject'] = 'NO-BS Agency';
        }

        return $this->subject($this->data['subject'])
                    ->view($this->view_mail);
    }
}
