<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LibraryItem;
use App\Models\CommentArticle;
use App\Models\CommentCourse;
use App\Models\Course;
use App\Models\User;
use App\Helper\ApiResponseHelper;
use App\Helper\Helper;

class CommentController extends Controller
{
    public function list($article_id)
    {
        $item = LibraryItem::where('id', $article_id)->first();
        $comment = $item->comment->map(function($item){
            $item->author = User::where('id', $item->user_id)->get()->map(function($user){
                $user->photo = Helper::getUrls($user, 'profilePhoto');
                return $user;
            });
            return $item;
        });
        return ApiResponseHelper::success($comment);
    }

    public function create(Request $request)
    {
        $user = auth()->user()->id;
        $comment = CommentArticle::create([
            'user_id' => $user,
            'article_id' => $request->article_id,
            'comment' => $request->comment
        ]);
        return ApiResponseHelper::success($comment);

    }

    public function delete($comment_id)
    {
        $user = auth()->user()->id;
        CommentArticle::where('id', $comment_id)->where('user_id', $user)->delete();
        return ApiResponseHelper::success();
    }

    public function edit(Request $request)
    {
        $user = auth()->id();

        $comment = CommentArticle::where('user_id', $user)
            ->where('article_id', $request->article_id)
            ->first();

        if (!$comment) {
            return ApiResponseHelper::error('Комментарий не найден', 404);
        }

        $comment->update(['comment' => $request->comment]);

        return ApiResponseHelper::success($comment);
    }

    public function courseCreate(Request $request){
        $user = auth()->user()->id;
        $comment = CommentCourse::create([
            'user_id' => $user,
            'course_id' => $request->course_id,
            'part_id' => $request->part_id,
            'comment' => $request->comment
        ]);
        return ApiResponseHelper::success($comment);
    }

    public function courseList($course_id, $part_id){
        $item = Course::where('id', $course_id)->first();
        return ApiResponseHelper::success($item->comment);
    }
}
