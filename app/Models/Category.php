<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
	use HasFactory, AsSource, Attachable;

    protected $fillable = [
        'training',
        'name',
        'name_kz',
    ];
    protected $hidden = ['name_kz'];
    
    public function getNameAttribute()
    {
        return $this->getLocalizedField('name');
    }

    public function getFullAttribute(): string
    {
        return sprintf('%s (%s)', $this->name, $this->training === 1 ? 'Повышение квалификации':'Переподготовка');
    }
}
