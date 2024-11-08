<?php namespace App\ModelsChat;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $fillable = [
        'room_type', 'user_ids'
    ];

    /**
     * Get the messages of a chat room
     */
    public function messages()
    {
        return $this->hasMany('App\ModelsChat\Message', 'chat_room_id')->with('sender');
    }
}
