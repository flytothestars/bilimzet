<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulePassed extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'course_module_id', 'type'
    ];

    public function courseModule()
    {
        return $this->belongsTo('App\Models\CourseModule', 'course_module_id');
    }
}