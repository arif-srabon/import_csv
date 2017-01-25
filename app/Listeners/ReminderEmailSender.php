<?php

namespace App\Listeners;

use App\Events\ReminderEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class ReminderEmailSender
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
        //die('Mail sender working');
    }

    /**
     * Handle the event.
     *
     * @param  SomeEvent  $event
     * @return void
     */
    public function handle(ReminderEvent $event)
    {
        $user = $event->user;
        $reminder = $event->reminder;

        $data = [
            'email' => $user->official_email,
            'name' => $user->full_name,
            'subject' => 'Reset Your Password',
            'code' => $reminder->code,
            'id' => $user->id
        ];


        Mail::queue('emails.reminder', $data, function($message) use ($data) {
            $message->to($data['email'], $data['name'])->subject($data['subject']);
        });
    }
}
