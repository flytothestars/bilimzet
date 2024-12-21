<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Pay\PayboxService;
use App\Helper\ApiResponseHelper;
use App\Models\Course;
use Illuminate\Support\Facades\Log;

class BuyController extends Controller
{
    protected $payboxService;

    public function __construct(PayboxService $payboxService)
    {
        $this->payboxService = $payboxService;
    }

    public function generateFrame($course_id, $part_id)
    {
        $course = Course::with(['parts' => function($query) use ($part_id) {
            $query->where('id', $part_id); // Фильтруем части по ID
        }])->find($course_id);
        $part = $course->parts->first();
        
        $name = $course->title;
        $price = $part->price_kzt;
        $paybox = $this->payboxService->init($price, $name, $course_id, $part_id);
        return ApiResponseHelper::success(['pg_redirect_url' => $paybox['pg_redirect_url']]);
    }

    public function success(Request $request)
    {
        Log::info('=====================================');
        Log::info('Оплачен');
        Log::info($request);
        Log::info('=====================================');
    }

    public function result(Request $request)
    {
        Log::info('=====================================');
        Log::info('result');
        Log::info($request);
        Log::info('=====================================');
    }
}
