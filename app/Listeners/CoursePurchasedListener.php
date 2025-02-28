<?php

namespace App\Listeners;

use App\Events\CoursePurchased;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\UserNotifications;

class CoursePurchasedListener
{

    /**
     * Handle the event.
     */
    public function handle(CoursePurchased $event): void
    {
        UserNotifications::create([
            'user_id' => $event->user->id,
            'type' => 'course_purchased',
            'message' => "Вы приобрели часть курса: " . $event->courseName,
        ]);
        
    }
}
