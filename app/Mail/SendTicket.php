<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTicket extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
{
    $this->request = $request;

    if (isset($this->request['emission_id'])) {
        $emissionId = $this->request['emission_id'];
        $this->subject = "Haz recibido un ticket identificado con el número $emissionId - " . setting('project', config('app.name', 'Laravel'));
    } else {
        $this->subject = "Haz recibido un ticket - " . setting('project', config('app.name', 'Laravel'));
    }
}


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $request = $this->request;
        return $this->view('email.send_ticket', compact('request'));


    }
}
