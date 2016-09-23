<?php

namespace App\Listeners;

class UserEventSubscriber
{

    /**
     * Handle user login events.
     */
    public function activateProjectOnLogin($event) {
        if($event->user->currentTeam === null && $event->user->teams->count() > 0){
            $event->user->switchTeam($event->user->teams->first());
        }
    }

    /**
     * Handle user login events.
     */
    public function logUserLogin($event) {
        activity('login')
            ->on($event->user)
            ->causedBy($event->user)
            ->log("User :causer.name logged in.");
    }

    /**
     * Handle user logout events.
     */
    public function logUserLogout($event) {
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
            'App\Listeners\UserEventSubscriber@activateProjectOnLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@logUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@logUserLogout'
        );

        $events->listen(
            'Jrean\UserVerification\Events\VerificationEmailSent',
            'App\Listeners\UserEventSubscriber@onUserSentEmailVerification'
        );
    }
}
