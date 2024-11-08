<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\PageController;
use App\LecturesItem;
use App\Util\Traits\HasPagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LectureController extends PageController
{
    use HasPagination;

    public function index()
    {
        $this->onPaginationIndex();

        $items = LecturesItem::paginate(self::DEFAULT_PAGE_SIZE);
        return view('admin.lectures', [
            'items' => $items
        ]);
    }

    public function edit($id)
    {
        return view('admin.lecturesItem', $id);
    }

    public function update($id, Request $request) {
        return redirect()->route('admin.lectures');
    }

    public function destroy($id)
    {
        return back();
    }
}
