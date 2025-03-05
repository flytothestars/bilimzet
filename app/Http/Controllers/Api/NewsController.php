<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Helper\ApiResponseHelper;
use App\Helper\Helper;

class NewsController extends Controller
{
    public function list()
    {
        $items = News::orderBy('created_at', 'desc')->get()->map(function ($item) {
            $item->miniature = Helper::getUrls($item);
            $item->plain_text = strip_tags($item->text);
            return $item;
        });

        return ApiResponseHelper::success($items);
    }

    public function detail($lang, $id)
    {
        $item = News::find($id);
        $item->update([
            'view_count' => $item->view_count + 1 
        ]);
        if($item){
            $item->miniature = Helper::getUrls($item);
            $item->plain_text = strip_tags($item->text);
        }

        return ApiResponseHelper::success($item);
    }
}
