<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LibraryItem;
use App\Models\Category;
use App\Models\User;
use App\Helper\ApiResponseHelper;
use App\Helper\Helper;
use Orchid\Attachment\File;
use App\Http\Resources\ArticleResource;

use App\Http\Controllers\Api\CapitalDTO;
use App\Http\Controllers\Api\CapitalService;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function index()
    {
		$categories = Category::where('training', 1)
            ->get()->map(function ($item) {
                $item->picture = Helper::getUrls($item);
                return $item;
            });
        $item = $categories->map(function ($category) {
            $category->article = LibraryItem::where('is_published', 1)
                ->where('category', $category->id)
                ->orderBy('created_at', 'DESC')
                ->get()->map(function($item){
                    $item->author = User::where('id', $item->author_id)->get()->map(function($user){
                        $user->photo = Helper::getUrls($user, 'profilePhoto');
                        return $user;
                    });
                    $item->category = Category::find($item->category);
                    $item->document = Helper::getUrls($item, 'articleDocument');
                    $item->document_extension = Helper::getExtension($item, 'articleDocument');
                    $item->document_extension = url('/images/extension/'.Helper::getExtension($item, 'articleDocument').'.png');
                    $item->document_size = Helper::getSize($item, 'articleDocument');
                    $item->plain_text = strip_tags($item->text);
                    $item->plain_text_kz = strip_tags($item->text_kz);
                    return $item;
                });
            return $category;
        });
        return ApiResponseHelper::success($item);
	}

    public function show($lang, $id)
    {
        $article = LibraryItem::where('is_published', 1)
            ->where('id', $id)
            ->orderBy('created_at', 'DESC')
            ->get()->map(function($item){
                $item->author = User::where('id', $item->author_id)->get()->map(function($user){
                $user->photo = Helper::getUrls($user, 'profilePhoto');
                return $user;
            });
            $item->category = Category::find($item->category);
            $item->document = Helper::getUrls($item, 'articleDocument');
            $item->document_extension = Helper::getExtension($item, 'articleDocument');
            $item->document_extension = url('/images/extension/'.Helper::getExtension($item, 'articleDocument').'.png');
            $item->document_size = Helper::getSize($item, 'articleDocument');        
            $item->document_size = Helper::getSize($item, 'articleDocument');
            $item->plain_text = strip_tags($item->text);
            $item->plain_text_kz = strip_tags($item->text_kz);
            return $item;
        })->first();
        
        $article->similar = LibraryItem::where('is_published', 1)
            ->where('author_id', $article->author_id)
            ->whereNot('id', $article->id)
            ->get()->map(function($item){
                $item->author = User::where('id', $item->author_id)->get()->map(function($user){
                    $user->photo = Helper::getUrls($user, 'profilePhoto');
                    return $user;
                });
                $item->document = Helper::getUrls($item, 'articleDocument');
                $item->document_extension = Helper::getExtension($item, 'articleDocument');
                $item->document_extension = url('/images/extension/'.Helper::getExtension($item, 'articleDocument').'.png');
                $item->document_size = Helper::getSize($item, 'articleDocument');    
                $item->document_size = Helper::getSize($item, 'articleDocument');
                return $item;
            });
        return ApiResponseHelper::success($article);
    }

    public function create(Request $request)
    {
        $user = auth()->user()->id;
        
        if (!$user) {
            return ApiResponseHelper::error('User not found', 404);
        }

        $item = new LibraryItem();
		$item->title = $request['title'];
		$item->title_kz = $request['title_kz'];
		$item->category = $request['category'];
		$item->text = $request['text'];
		$item->text_kz = $request['text_kz'];
        $item->author_id = $user;
        $item->save();
        $file = new File($request->file('document'), null,'articleDocument');
        $attachment = $file->load();
        // dd($attachment);
        $item->attachments()->syncWithoutDetaching(
            $attachment->id
        );
        
        return ApiResponseHelper::success(new ArticleResource($item));

    }

    public function showUserArticle()
    {
        $article = LibraryItem::where('author_id', auth()->user()->id)
            ->orderBy('created_at', 'DESC')
            ->get()->map(function($item){
                $item->author = User::where('id', $item->author_id)->get()->map(function($user){
                $user->photo = Helper::getUrls($user, 'profilePhoto');
                return $user;
            });
            $item->category = Category::find($item->category);
            $item->document = Helper::getUrls($item, 'articleDocument');
            $item->document_extension = Helper::getExtension($item, 'articleDocument');
            $item->plain_text = strip_tags($item->text);
            $item->plain_text_kz = strip_tags($item->text_kz);
            return $item;
        });
        return ApiResponseHelper::success($article);

    }
}
