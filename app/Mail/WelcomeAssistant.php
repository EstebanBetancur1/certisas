<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeAssistant extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $nameCompany;
    protected $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $nameCompany, $password)
    {
        $this->user = $user;
        $this->nameCompany = $nameCompany;
        $this->password = $password;

        $this->subject = "Bienvenido a " . setting('project', config('app.name', 'Laravel'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.welcome_assistant', [
            'user'          => $this->user,
            'nameCompany'   => $this->nameCompany,
            'password'      => $this->password,
        ]);
    }
}
