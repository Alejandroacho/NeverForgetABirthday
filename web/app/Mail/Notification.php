<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class Notification extends Mailable
{
    use Queueable, SerializesModels;

    protected $contact;
    protected $user;

    public function __construct($contact)
    {
        $this->contact = $contact;
        $this->user = DB::table('users')->where('id', $contact->user_id)->first();
    }

    public function build()
    {
        return $this->markdown('emails.notification')
        ->subject($this->user->name." ".$this->user->lastname." congratulates you ".$this->contact->name )
        ->from('congratulations@neverforgetabirthday.com', 'Never Forget A Birthday')
        ->with([
            'contact'=> $this->contact,
            'user'=> $this->user,
        ]);
    }
}
