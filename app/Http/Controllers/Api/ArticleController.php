<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LibraryItem;
use App\Models\Category;
use App\Helper\ApiResponseHelper;
use App\Helper\Helper;

class ArticleController extends Controller
{
    public function index()
    {
		$categories = Category::where('training', 1)
            ->get()->map(function ($item) {
                $item->picture = Helper::getUrl($item);
                return $item;
            });
        $item = $categories->map(function ($category) {
            $category->article = LibraryItem::with(['author' => function ($query) {
                    // $query->selectRaw("id, full_name, CONCAT('" . url('uploads/profile/') . "/', photo) as photo");
                }])
                ->where('is_published', 1)
                ->where('category', $category->id)
                ->orderBy('created_at', 'DESC')
                ->get()->map(function($item){
                    $item->document = Helper::getUrl($item);
                    $item->document_extension = Helper::getExtension($item);
                    return $item;
                });
            return $category;
        });
        return ApiResponseHelper::success($item);
	}

    public function show($id)
    {
        $article = LibraryItem::with(['author' => function ($query) {
            // $query->selectRaw("id, full_name, CONCAT('" . url('uploads/profile/') . "/', photo) as photo");
        }])
        ->where('is_published', true)
        ->where('id', $id)
        ->get()->map(function ($item) {
            $item->document = Helper::getUrl($item);
            $item->document_extension = Helper::getExtension($item);
            return $item;
        });

        return ApiResponseHelper::success($article);
    }

    public function create(Request $request)
    {
        dd($request);
        $item = new LibraryItem();
		$item->title = $request['title'];
		$item->title_kz = $request['title_kz'];
		$item->document_extension = '';
		$item->category = $request['category'];
		$item->text = $request['text'];
		$item->text_kz = $request['text_kz'];
		$item->document_extension = '';
		$item->document = '';
		// auth()->user()->libraryItems()->save($item);
        // $item->attachments()->syncWithoutDetaching(
        //     $request->input('document', [])
        // );
        
        return ApiResponseHelper::success($item);

    }

    public function showUserArticle()
    {
        $item = LibraryItem::where('author_id', auth()->user()->id)->get()->map(function ($item) {
            $item->document = Helper::getUrl($item);
            $item->document_extension = Helper::getExtension($item);
            return $item;
        });
        return ApiResponseHelper::success($item);

    }
}
