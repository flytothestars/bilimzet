<?php

namespace App\ModelsChat;

use Illuminate\Database\Eloquent\Model;

class RoomMember extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'chat_room_id', 'user_ids'
    ];

    /**
     * Get the sender of the message
     */
    public function chatRoom()
    {
        return $this->belongsTo('App\ModelsChat\ChatRoom');
    }

    public function getUserIdsAttribute($value)
    {
        return unserialize($value);
    }

    public function scopeMembers($query)
    {
        return $query->where('active', 1);
    }
}