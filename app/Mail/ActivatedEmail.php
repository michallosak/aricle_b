<?php

namespace App\Mail;

use App\Model\User\SpecificData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ActivatedEmail extends Mailable
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
        $data = [
            'name' => SpecificData::where('user_id', Auth::id())->value('name'),
            'email' => Auth::user()->email
        ];
        return $this->from('email@example.com', 'E-mail')
            ->subject($data['name'].' Activated account!')
            ->markdown('emails.activated')
            ->with([
                'data' => $data
            ]);
    }
}
