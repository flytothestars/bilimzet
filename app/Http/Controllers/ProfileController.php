<?php namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Olympic\OlympicSession;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\LibraryItem;
use App\ModelsChat\ChatRoom;
use App\ModelsChat\Message;
use App\ModelsChat\Receiver;

class ProfileController extends PageController
{
	private $footer_pages = [];

	public function __construct()
	{
		$pages = DB::select('select content from pages where page_filt = ?', ['footer']);
		foreach ($pages as $page) {
			$this->footer_pages[] = base64_decode($page->content);
		}
	}

	public function index()
	{
		$user = auth()->user();
		$courses = $user->getPurchasedCourses();
		$footer_pages = $this->footer_pages;

		$receiver = User::where('type', 'admin')->get();
		if ($receiver->count() > 0) {
			$receiver = $receiver[0];
			$receiverId = $receiver->id;
		}
		$senderUserId = auth()->user()->id;
		$sender = User::find($senderUserId);
		$roomMembers = [ $receiverId, $senderUserId ];
		sort($roomMembers);
		$roomMembers = implode(',', $roomMembers);

		$chatRoom = ChatRoom::where('user_ids', $roomMembers)->first();
		if (is_null($chatRoom)) {
			$chatRoom = new ChatRoom;
			$chatRoom->room_type = 'private';
			$chatRoom->user_ids = $roomMembers;
			$chatRoom->save();
		}

		// Get olympic results
        $olympicResults = OlympicSession::select('id', 'course_id')
            ->with('course')
            ->where('user_id', $user->id)
            ->whereNotNull('finished_at')
            ->get();

		return view('profile', compact('user','courses', 'chatRoom', 'sender', 'receiver', 'footer_pages', 'olympicResults'));
	}

	public function edit()
	{
		$footer_pages = $this->footer_pages;
		return view('profileEdit', [
			'user' => auth()->user(),
			'footer_pages' => $footer_pages
		]);
	}

	public function update(Request $request)
	{
		$rules = [
			'full_name' => 'required|string',
			'address' => 'required|string',
			'photo' => 'nullable|image|dimensions:min_width=100,min_height=100,max_height=1000,max_width=1000|max:2048',
			'diploma' => 'nullable|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png|max:10240',
		];
		$this->validate($request, $rules);
		$user = auth()->user();
		$user->fill($request->all());

		$user->receive_news_accept = $request->get('receive_news_accept') === 'true';

		$this->updateFile($user, 'photo', $request);
		$this->updateFile($user, 'diploma', $request);

		$user->save();
		return redirect()->route('profile');
	}

	private function updateFile(User $user, $fileFieldName, Request $request)
	{
		$uploads = User::getUploadsDir();
		$requestFile = $request->files->get($fileFieldName);
		if ($requestFile) {
			if ($user->$fileFieldName) {
				$uploads->deleteFile($user->$fileFieldName);
			}
			$user->$fileFieldName = $uploads->saveUploadedFile($requestFile);
		}
	}

	public function editPassword()
	{
		$footer_pages = $this->footer_pages;
		return view('passwordEdit', [
			'user' => auth()->user(),
			'footer_pages' => $footer_pages
		]);
	}

	public function updatePassword(Request $request)
	{
		$rules = [
			'current_password' => 'required',
			'new_password' => 'required|confirmed|min:6|different:current_password',
		];
		$this->validate($request, $rules);

		$user = auth()->user();
		$currentPassword = $request->get('current_password');
		$newPassword = $request->get('new_password');

		if (!Hash::check($currentPassword, $user->password)) {
			throw ValidationException::withMessages([
				'error' => 'Неправильно указан текущий пароль'
			]);
		}

		$user->password = Hash::make($newPassword);
		$user->save();

		return redirect()
			->route('profile')
			->with('message', 'Пароль был успешно изменён');
	}

	public function freeMoney()
	{
		$user = auth()->user();
		$user->money_amount_kzt += 50000;
		$user->save();

		Notification::createForFreeMoney();

		return redirect()
			->route('profile')
			->with('message', 'Вам были начислены 50000 Т');
	}

	public function user(Request $request, $id)
	{
		$user = User::find($id);
		$articles = LibraryItem::where([ 'author_id' => $id, 'is_published' => 1 ])->get();
		$footer_pages = $this->footer_pages;
		return view('user', compact('user', 'articles', 'footer_pages'));
	}
}
