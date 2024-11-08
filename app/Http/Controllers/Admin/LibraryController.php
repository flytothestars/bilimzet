<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\PageController;
use App\LibraryItem;
use App\Util\Traits\HasPagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LibraryController extends PageController
{
    use HasPagination;

    public function index()
    {
        $this->onPaginationIndex();

        $items = LibraryItem::paginate(self::DEFAULT_PAGE_SIZE);
        return view('admin.library', [
            'items' => $items
        ]);
    }

    public function edit($id)
    {
        $item = LibraryItem::findOrFail($id);
	    $categories = Lang::get('courses.categories');
	    $categoryNames = array_keys($categories);

        return view('admin.libraryItem', compact('item', 'categoryNames'));
    }

    public function update($id, Request $request) {
        $rules = [
            'title' => 'required',
            'document' => 'nullable|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png|max:10240',
            'category' => 'required',
            'text' => 'required',
        ];
        $this->validate($request, $rules);
        $item = LibraryItem::findOrFail($id);
        $item->fill($request->all());
        $item->is_published = $request->get('is_published') === 'true';
        $uploads = LibraryItem::getUploadsDir();
        $documentFile = $request->files->get('document');
        if($documentFile) {
            $item->deleteDocument();
            $item->document = $uploads->saveUploadedFile($documentFile);
            $item->document_extension = $documentFile->getClientOriginalExtension();
        }
        $item->save();
        return redirect()->route('admin.library');
    }

    public function destroy($id)
    {
        $item = LibraryItem::findOrFail($id);
        $item->deleteDocument();
        $item->delete();
        return back();
    }
}
