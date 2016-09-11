<?php

namespace App\Listeners;

class UserEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function onUserLogin($event) {
        activity('login')
            ->on($event->user)
            ->causedBy($event->user)
            ->log("User :causer.name logged in.");
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) {
        activity('logout')
            ->on($event->user)
            ->causedBy($event->user)
            ->log("User :causer.name logged out.");
    }

    /**
     * Handle user logout events.
     */
    public function onUserSentEmailVerification($event) {
        activity('email verification')
            ->on($event->user)
            ->causedBy($event->user)
            ->log("User :causer.name resent email verification.");
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

        $events->listen(
            'Jrean\UserVerification\Events\VerificationEmailSent',
            'App\Listeners\UserEventSubscriber@onUserSentEmailVerification'
        );
    }
}
