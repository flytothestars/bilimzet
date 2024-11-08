<?php namespace App\Http\Controllers\Admin;

use App\News;
use App\Http\Controllers\PageController;
use App\Util\Traits\HasPagination;
use App\Util\ValidationUtils;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsController extends PageController
{
    use HasPagination;

    const STORE_RULES = [
        'name' => 'required|string',
        'miniature' => 'image|dimensions:max_height=1000,max_width=1000|max:2048',
        'text' => 'required|string',
    ];

    public function index()
    {
        $this->onPaginationIndex();

        $items = News::orderBy('name')
            ->paginate(self::DEFAULT_PAGE_SIZE);
        return view('admin.news', [
            'items' => $items
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.new', [
            'item' => null,
            'formAction' => route('admin.storeNew')
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, self::STORE_RULES);

        $item = new News($request->all());
        $item->saveDeclaredFiles($request->files);
        $item->save();

        return redirect()->route('admin.news');
    }

    public function update($id, Request $request) {
        $this->validate($request, self::STORE_RULES);
        $item = News::findOrFail($id);
        $item->fill($request->all());
        $uploads = News::getUploadsDir();
        $documentFile = $request->files->get('miniature');
        if($documentFile) {
            $item->deleteDocument();
            $item->miniature = $uploads->saveUploadedFile($documentFile);
        }
        $item->save();
        return redirect()->route('admin.newPost', ['id' => $id]);
    }

    public function edit($id)
    {
        $item = News::findOrFail($id);
        return view('admin.new', [
            'item' => $item,
            'formAction' => route('admin.updateNew', ['id' => $id])
        ]);
    }

    public function destroy($id)
    {
        $new = News::find($id);
        $new->deleteDocument();
        $new->delete();
        return redirect()->route('admin.news');
    }
}
