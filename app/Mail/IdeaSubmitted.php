<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Idea;

class IdeaSubmitted extends Mailable
{
    public $idea;
    public $staffName;
    public $staffEmail;
    

    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
        $this->staffName = $idea->user ? $idea->user->name : 'Anonymous';
        $this->staffEmail = $idea->user->email ?? 'No Email';
    }

    public function build()
    {
        return $this->subject('New Idea Submitted')
                    ->html('<p>A new idea has been submitted.</p>
                            <p><strong>Submitted by:</strong> ' . $this->staffName . ' (' . $this->staffEmail . ')</p>
                            <p><strong>Title:</strong> ' . $this->idea->title . '</p>
                            <p><strong>Description:</strong> ' . $this->idea->description . '</p>');
    }
}
