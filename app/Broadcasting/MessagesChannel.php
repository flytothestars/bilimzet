<?php namespace App\Broadcasting;

use App\User;
use App\ModelsChat\ChatRoom;

class MessagesChannel
{
    /**
     * @param User $user
     * @param int $chat_room_id
     * @return bool
     */
    public function join(User $user, int $chat_room_id)
    {
	    $chatRoom = ChatRoom::find($chat_room_id);
	    $ids = explode(',', $chatRoom->user_ids);

	    if ($chatRoom) {
		    if (in_array((int)$user->id, $ids)) {
			    return true;
		    }
	    }
        return false;
    }
}
