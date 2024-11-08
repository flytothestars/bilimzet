<?php namespace App\Http\Controllers\Admin;

use App\Gid;
use App\Http\Controllers\PageController;
use App\Util\Traits\HasPagination;
use Illuminate\Http\Request;

class GuideController extends PageController
{
	use HasPagination;

	const STORE_RULES = [
		'title' => 'required|string',
		'video' => 'string',
		'text' => 'required|string',
	];

	public function index()
	{
		$this->onPaginationIndex();

		$items = Gid::paginate(self::DEFAULT_PAGE_SIZE);

		return view('admin.guides', compact('items'));
	}

	public function create(Request $request)
	{
		$item = null;
		return view('admin.guide', compact('item'));
	}

	public function store(Request $request)
	{
		$this->validate($request, self::STORE_RULES);

		$item = new Gid($request->all());
		$item->save();

		return redirect()->route('admin.guides');
	}

	public function edit($id)
	{
		$item = Gid::findOrFail($id);
		return view('admin.guide', compact('item', 'id' ));
	}

	public function update($id, Request $request)
	{
		$this->validate($request, self::STORE_RULES);

		$item = Gid::findOrFail($id);
		$item->fill($request->all());
		$item->save();

		return redirect()->route('admin.guides');
	}

	public function destroy($id)
	{
		$new = Gid::find($id);
		$new->delete();
		return redirect()->route('admin.guides');
	}
}
