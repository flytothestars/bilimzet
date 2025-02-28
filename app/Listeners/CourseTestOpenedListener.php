<?php

namespace App\Listeners;

use App\Events\CourseTestOpened;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseTestOpenedListener
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
    public function handle(CourseTestOpened $event): void
    {
        //
    }
}
