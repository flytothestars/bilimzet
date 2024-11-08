<?php namespace App\Http\Controllers;

use App\User;
use App\Util\Phpbb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AuthController extends PageController
{
	private $footer_pages = [];

	public function __construct()
	{
		$pages = DB::select('select content from pages where page_filt = ?', ['footer']);
		foreach ($pages as $page) {
			$this->footer_pages[] = base64_decode($page->content);
		}
	}

	public function loginIndex()
	{
		$footer_pages = $this->footer_pages;
		return view('login', compact('footer_pages'));
	}

	public function doLogin(Request $request)
	{
		$rules = [
			'email' => 'required|email',
			'password' => 'required|min:6',
		];
		$this->validate($request, $rules);

		$credentials = $request->only('email', 'password');
		if (Auth::attempt($credentials)) {
			return redirect()->intended('login');
		}
		throw ValidationException::withMessages(['error' => 'Не удалось войти']);
	}

	public function regIndex()
	{
		$footer_pages = $this->footer_pages;
		return view('reg', compact('footer_pages'));
	}
	
	public function regNUIndex()
	{
		$footer_pages = $this->footer_pages;
		return view('regNU', compact('footer_pages'));
	}

	public function doReg(Request $request)
	{
		$rules = [
			'full_name' => 'required|string',
			'address' => 'required|string',
			'password' => 'required|confirmed|min:6',
			'email' => 'required|email|unique:users',
			'photo' => 'nullable|image|dimensions:min_width=100,min_height=100,max_height=1000,max_width=1000|max:2048',
			'diploma' => 'nullable|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png|max:10240',
		];
		$this->validate($request, $rules);
		$user = new User($request->all());
		$user->password = Hash::make($request->get('password'));
		$user->name = $user->email = $request->get('email');
		$user->receive_news_accept = $request->get('receive_news_accept') === 'true';
		if($request->get('querylec') === 'true') $user->status_lector = 0;
		$uploads = User::getUploadsDir();
		$user->photo = $uploads->saveUploadedFile($request->file('photo'));
		$user->diploma = $uploads->saveUploadedFile($request->file('diploma'));
		$user->save();
		Phpbb::createUser($user->name, $request->get('password'));
		Auth::attempt($request->only('email', 'password'), true);
		return redirect()->route('profile');
	}
	
	public function doRegNU(Request $request)
	{
		die("Данные сохранены");
		return redirect()->route('regNU');
	}

	public function logout()
	{
		Session::flush();
		Auth::logout();
		return redirect()->route('login');
	}
}
