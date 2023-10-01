<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SendInvitation extends Mailable
{
    use Queueable, SerializesModels;


    private $user;
    private $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->url = 'https://lovedhusband.enginydigitaleco.com';
        do {
            $user->token = Str::random(40);
            $user->token_time = now();
        } while (!$user->update());

        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $this->subject('Convite Loved Husband!');
        $this->to(decrypt($this->user->email));
        return $this->view(
            'mail.invitation',
            [
                'token' => $this->user->token,
                'url' => $this->url,
            ]
        );
    }
}
