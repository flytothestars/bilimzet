<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LibraryItem;
use App\Models\CommentArticle;
use App\Helper\ApiResponseHelper;

class CommentController extends Controller
{
    public function list($article_id)
    {
        $item = LibraryItem::where('id', $article_id)->first();
        return ApiResponseHelper::success($item->comment->get());
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
}
