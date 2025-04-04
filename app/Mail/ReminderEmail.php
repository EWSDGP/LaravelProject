<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->subject('Reminder Notification')
                    ->html('
                            <p>Dear Team,</p>
                            <p>This is a kind reminder to ensure that each staff member submits at least one post as part of our ongoing quality assurance and engagement efforts. Regular contributions are important in maintaining consistency, sharing insights, and keeping our communication flow active.</p>
                            <p>Please make sure to complete at least one post within the designated time frame. Your participation is appreciated and plays a vital role in our team’s progress and collaboration.</p>
                            <p>Thank you for your attention and continued commitment.</p>
                            <p>Best regards,<br>
                            QA Coordinator</p>');
    }
}
