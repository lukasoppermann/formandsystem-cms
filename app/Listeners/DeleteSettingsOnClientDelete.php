<?php

namespace App\Listeners;

use App\Events\ClientWasDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\ApiClientDetailService;

class DeleteSettingsOnClientDelete
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
     * @param  ClientWasDeleted  $event
     * @return void
     */
    public function handle(ClientWasDeleted $event)
    {
        foreach(['database','ftp_image','ftp_backup'] as $detail){
            (new ApiClientDetailService)->delete($event->account()->getModel(), $detail);
        }
    }
}
