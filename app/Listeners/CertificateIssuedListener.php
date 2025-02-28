<?php

namespace App\Listeners;

use App\Events\CertificateIssued;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\UserNotifications;

class CertificateIssuedListener
{

    /**
     * Handle the event.
     */
    public function handle(CertificateIssued $event): void
    {
        UserNotifications::create([
            'user_id' => $event->user->id,
            'type' => 'certificate_issued',
            'message' => "Вам выдан сертификат по курсу - " .$event->data,
        ]);
        
    }
}
