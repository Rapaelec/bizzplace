<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class messageToEmployee extends Mailable
{
    public $nom_employe;
    public $prenom_employe;
    public $nom_entreprise;
    public $code_privilege;
    public $dure_cart;
    public $adress_mail_enterprise;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nom_employe,$prenom_employe,$nom_entreprise,$dure_cart,$adress_mail_enterprise)
    {
        $this->nom_employe=$nom_employe;
        $this->prenom_employe= $prenom_employe;
        $this->nom_entreprise = $nom_entreprise;
        $this->dure_cart = $dure_cart;
        $this->adress_mail_enterprise= $adress_mail_enterprise;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->adress_mail_enterprise)
        ->markdown('emails.EmailToEmployee.messageCartGiftToEmployee');
    }
}
