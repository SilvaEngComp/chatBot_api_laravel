<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;


    public $playload;
    private $url;
    private $viewPath;
    private $subjectText;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($playload)
    {
        $this->setPlayload($playload);

        if ($this->playload['isInvite']) {
            $this->setViewPath('mail.invitation');
            $this->setSubjectText('Código de Recuperação de Acesso!');
        } else {
            $this->setViewPath('mail.emailRescueCode');
            $this->setSubjectText('Convite do ICIA');
        }

        $this->setUrl('https://icia.herokuapp.com/');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return
            $this->subject($this->getSubjectText())
            ->view(
                $this->viewPath,
                [
                    'url' => $this->getUrl(),
                    'userName' => $this->playload['name'],
                    'token' => $this->playload['token']
                ]
            );
    }

    /**
     * Get the value of playload
     */
    public function getPlayload()
    {
        return $this->playload;
    }

    /**
     * Set the value of playload
     */
    public function setPlayload($playload): self
    {
        $this->playload = $playload;

        return $this;
    }

    /**
     * Get the value of url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of url
     */
    public function setUrl($url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of view
     */
    public function getViewPath()
    {
        return $this->viewPath;
    }

    /**
     * Set the value of view
     */
    public function setViewPath($view): self
    {
        $this->viewPath = $view;

        return $this;
    }

    /**
     * Get the value of subject
     */
    public function getSubjectText()
    {
        return $this->subjectText;
    }

    /**
     * Set the value of subject
     */
    public function setSubjectText($subject): self
    {
        $this->subjectText = $subject;

        return $this;
    }
}
