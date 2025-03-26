<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BannedNotification extends Mailable
{
    public function build()
    {
        return $this->subject('BannedNotification')
                    ->html('<p><strong>Your post has a new comment.</strong></p>');

    }
}
