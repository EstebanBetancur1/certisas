<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Alert extends Mailable
{
    use Queueable, SerializesModels;

    protected $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($provider)
    {
        $this->provider = $provider;


        $this->subject = "Certificado Virtual expedido por {$provider["agent_nit"]} - {$provider["agent_name"]}";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.alert', [
            'provider'   => $this->provider
        ]);
    }
}
