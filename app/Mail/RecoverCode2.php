<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class RecoverCode2 extends Mailable
{
    use Queueable, SerializesModels;


    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {


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

        $email = 'silvaengcomp@gmail.com';
        $this->subject('Código de Recuperação de Acesso!');
        $this->to($email, $this->user->name);

        return $this->view(
            'mail.emailRescueCode',
            [
                'userName' => $this->user->name,
                'token' => $this->user->token
            ]
        );
    }
}
