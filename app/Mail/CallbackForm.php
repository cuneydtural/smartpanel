<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CallbackForm extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * ContactForm constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->subject('Biz Sizi Arayalım - '. $data['name']);
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.mail.callback_form_result');
    }
}
