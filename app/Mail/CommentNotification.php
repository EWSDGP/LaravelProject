<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentNotification extends Mailable
{
    public function build()
    {
        return $this->subject('New Comment Notification')
                    ->html('<p><strong>Your post has a new comment.</strong></p>');

    }
}
