<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $data;

    /**
     * VerifyEmail constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('email@example.pl', 'E-mail')
            ->subject('Verify Email '.$this->data['name'])
            ->markdown('emails.verify')
            ->with([
                'name' => $this->data['name'],
                'email' => $this->data['email'],
                'key' => $this->data['key']
            ]);
    }
}
