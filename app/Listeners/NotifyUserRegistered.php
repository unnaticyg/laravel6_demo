<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\User;
use Mail;

class NotifyUserRegistered
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user = User::find($event->userId)->toArray();
        Mail::send('emails.registration', $user, function($message) use ($user) {
            $message->to($user['email']);
            $message->from('unnatiprajapati81@gmail.com','TEST');
            $message->subject('Register User Testing');
            
        });
    }
}
