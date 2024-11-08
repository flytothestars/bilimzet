<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\PageController;
use App\Util\Traits\HasPagination;
use Illuminate\Http\Request;
use App\Events\ChatMessage;
use App\User;
use App\ModelsChat\ChatRoom;
use App\ModelsChat\Message;
use App\ModelsChat\Receiver;

class SupportController extends PageController
{
	public function index()
	{
		$chatrooms = ChatRoom::get();
		foreach ($chatrooms as &$chatroom) {
			$user_ids = explode(',', $chatroom->user_ids);
			$chatroom->full_name = isset(User::find($user_ids[1])->full_name) ? User::find($user_ids[1])->full_name : '';
			$msg = '';
			if (count($chatroom->messages)) {
				$msg = $chatroom->messages[ count($chatroom->messages) - 1 ]->message;
			}
			$viewed = count($chatroom->messages) == 0;
			foreach ($chatroom->messages as $message) {
			$chatroom->updated_at = $message->updated_at;
				if ($message->viewed) {
					$viewed = true;
					break;
				}
			}
			$chatroom->viewed = $viewed;
			$chatroom->message = $msg;
		}

	$chatrooms->sortBy('updated_at');
		
		return view('admin.support', compact('chatrooms'));
	}

	public function chat(ChatRoom $chatroom)
	{
		$senderId = auth()->user()->id;
		$roomMembers = collect(explode(',', $chatroom->user_ids));
		$roomMembers->forget($roomMembers->search($senderId));
		$user = User::find($roomMembers->first());
		foreach ($chatroom->messages as &$message) {
			$message->viewed = true;
			$message->save();
		}

		return view('admin.chat', compact('user', 'chatroom'));
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
		}

		return redirect()->route('admin.chat', [ 'chatroom' => $chatroom->id ]);
	}
}
