<?php

namespace App\Listeners;

use App\Events\AuditStored;
use App\Models\AuditTrail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AuditStoreListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AuditStored $event): void
    {
        AuditTrail::create([
            'user_id' => auth()->user()->id,
            'action' => $event->data['action'],
            'type' => $event->data['type'],
            'url' => $event->data['url'],
            'message' => $event->data['message'],
            'blood_issuance_id' => $event->data['blood_issuance_id']
        ]);
    }
}
