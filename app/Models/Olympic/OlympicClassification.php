<?php

namespace App\Models\Olympic;

use Illuminate\Database\Eloquent\Model;

class OlympicClassification extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];
}
