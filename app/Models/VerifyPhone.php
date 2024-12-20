<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyPhone extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'code',
        'is_verify',
        'expired_at'
    ];
}
