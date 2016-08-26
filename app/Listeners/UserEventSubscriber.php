<?php

namespace App\Listeners;

class UserEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function onUserLogin($event) {
        activity('logins')
           ->causedBy($event->user)
           ->log("User :causer.name logged in.");
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) {
        activity('logouts')
           ->causedBy($event->user)
           ->log("User :causer.name logged out.");
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );
    }
}
