<?php

namespace App\Listeners;

use App\Events\CaseCreate;
use App\Notifications\CaseCreateNotification;
use App\Notifications\NewUserNotification;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendCaseNotification
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
     * @param  \App\Events\CaseCreate  $event
     * @return void
     */
    public function handle(CaseCreate $event)
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('id', 1);
        })->get();

        Notification::send($admins, new CaseCreateNotification($event->user));
    }
}
