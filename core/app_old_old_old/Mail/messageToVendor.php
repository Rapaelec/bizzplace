<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class messageToVendor extends Mailable
{
    use Queueable, SerializesModels;

    public $nom_client;
    public $adress_email;
    public $subject_client;
    public $phone_client;
    public $message_client;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nom_client,$phone_client,$adress_email,$subject_client,$message_client)
    {
        $this->nom_client = $nom_client;
        $this->adress_email = $adress_email;
        $this->subject_client = $subject_client; 
        $this->message_client = $message_client;
        $this->phone_client = $phone_client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->adress_email)
        ->markdown('emails.EmailToVendorForPlaceOrder.messageToVendor');
    }
}
