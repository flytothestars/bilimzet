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
            $item->plain_text_kz = strip_tags($item->text_kz);
            return $item;
        });

        return ApiResponseHelper::success($items);
    }

    public function detail($id)
    {
        $item = News::find($id);
        if($item){
            $item->miniature = Helper::getUrls($item);
            $item->plain_text = strip_tags($item->text);
            $item->plain_text_kz = strip_tags($item->text_kz);
        }
        return ApiResponseHelper::success($item);
    }
}
