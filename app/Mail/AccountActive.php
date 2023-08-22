<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountActive extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $company)
    {
        $this->user = $user;
        $this->company = $company;

        $this->subject = "Cuenta Verificada - " . setting('project', config('app.name', 'Laravel'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.account_active', [
            'user' => $this->user,
            'company' => $this->company,
        ]);
    }
}
