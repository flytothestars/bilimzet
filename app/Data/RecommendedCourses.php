<?php namespace App\Data;

use App\Course;

class RecommendedCourses
{
    public static function get()
    {
        return Course::with([ 'parts', 'speciality' ])
            ->inRandomOrder()
            ->limit(5)
            ->get();
    }
}
