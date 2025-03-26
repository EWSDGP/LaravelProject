<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UnbannedNotification extends Mailable
{
    public function build()
    {
        return $this->subject('Unbanned Notification')
                    ->html('<p><strong>Your account has been unbanned.</strong></p>');

    }
}
