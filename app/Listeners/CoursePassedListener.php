<?php

namespace App\Listeners;

use App\Events\CoursePassed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CoursePassedListener
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
    public function handle(CoursePassed $event): void
    {
        //
    }
}
