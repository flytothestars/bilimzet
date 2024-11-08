<?php namespace App\ModelsChat;

use App\User;
use App\ModelsChat\Receiver;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function sender() {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    public function receivers() {
        return $this->hasMany(Receiver::class);
    }
}
