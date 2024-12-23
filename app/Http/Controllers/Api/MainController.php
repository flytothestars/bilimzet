<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Helper\ApiResponseHelper;
use App\Models\Course;
use App\Models\LibraryItem;
use App\Helper\Helper;
use App\Models\User;
use App\Models\Category;

class MainController extends Controller
{
    public function feedback(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'email' => 'nullable|string',
            'name'  => 'nullable|string',
        ]);
        $feedback = FeedBack::create([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'email'     => $request->email,
        ]);

        if(!$feedback)
        {
            return ApiResponseHelper::error();
        }

        return ApiResponseHelper::success();
    }

    public function search(Request $request){
        $request->validate([
            'data'  => 'nullable|string',
        ]);
        $searchTerm = $request->data;
        $results = [];
        $resultsModelCourse = Course::where('title', 'LIKE', "%{$searchTerm}%")
            ->orWhere('desc_text', 'LIKE', "%{$searchTerm}%")
            ->get(['id','title', 'desc_text'])
            ->map(function ($item) {

                return [
                    'type'          => 'course',
                    'title'         => $item->title,
                    'description'   => strip_tags($item->desc_text),
                    'url'           => url('api/course/'.$item->id),
                    'picture'       => url('images/icons/'.rand(1,50).'.png'),
                ];
            });
            
        // dd($resultsModelCourse);
        return ApiResponseHelper::success($resultsModelCourse);
    }

    public function searchArticle(Request $request){
        $request->validate([
            'data'  => 'nullable|string',
        ]);
        $searchTerm = $request->data;
        $results = [];
        $resultsModelArticle = LibraryItem::where('is_published', 1)
            ->where('title', 'LIKE', "%{$searchTerm}%")
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
                $item->plain_text = strip_tags($item->text);
                $item->plain_text_kz = strip_tags($item->text_kz);
                return $item;
        });
            
        // dd($resultsModelCourse);
        return ApiResponseHelper::success($resultsModelArticle);
    }
}
