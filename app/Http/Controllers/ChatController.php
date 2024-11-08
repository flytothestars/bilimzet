<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\ChatMessage;
use App\User;
use App\ModelsChat\ChatRoom;
use App\ModelsChat\Message;
use App\ModelsChat\Receiver;
use Illuminate\Routing\Controller;

class ChatController extends Controller
{
	public function fetch(ChatRoom $chatroom)
	{
		return $chatroom->messages;
	}

	public function store(ChatRoom $chatroom)
	{
		$senderId = auth()->user()->id;
		$roomMembers = collect(explode(',', $chatroom->user_ids));
		$roomMembers->forget($roomMembers->search($senderId));
		$receiverId = $roomMembers->first();

		$message = new Message;
		$message->chat_room_id = $chatroom->id;
		$message->sender_id = $senderId;
		$message->message = request('body');
		$message->save();

		$receiver = new Receiver;
		$receiver->message_id = $message->id;
		$receiver->receiver_id = $receiverId;

		if ($receiver->save()) {
			$message = Message::with('sender')->find($message->id);
			broadcast(new ChatMessage($message))->toOthers();
			return $message;
		} else {
			return 'Something went wrong!!';
		}
	}
}
