<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Pay\PayboxService;
use App\Helper\ApiResponseHelper;
use App\Models\Course;
use App\Models\CourseBuy;
use Illuminate\Support\Facades\Log;
use App\Models\TransactionLog;

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
        $paybox = $this->payboxService->init($course, $part);
        return ApiResponseHelper::success(['pg_redirect_url' => $paybox['pg_redirect_url']]);
    }

    public function success(Request $request)
    {
        $order = explode('-', $request['pg_order_id']);
        $course = CourseBuy::create([
            'user_id' => $order[2],
            'course_part_id' => $order[1],
            'course_id' => $order[0]
        ]);
        Log::info('=====================================');
        Log::info('Оплачен');
        Log::info($request);
        Log::info($course);
        Log::info('=====================================');
        return redirect()->to('https://testbilimzet.kz');
    }

    public function result(Request $request)
    {
        $validatedData = $request->validate([
            'pg_order_id' => 'required|string',
            'pg_payment_id' => 'required|string',
            'pg_amount' => 'required|numeric',
            'pg_currency' => 'required|string',
            'pg_net_amount' => 'required|numeric',
            'pg_ps_amount' => 'required|numeric',
            'pg_ps_full_amount' => 'required|numeric',
            'pg_ps_currency' => 'required|string',
            'pg_description' => 'required|string',
            'pg_result' => 'required|boolean',
            'pg_payment_date' => 'required|date',
            'pg_can_reject' => 'required|boolean',
            'pg_user_phone' => 'required|string',
            'pg_need_phone_notification' => 'required|boolean',
            'pg_user_contact_email' => 'required|email',
            'pg_need_email_notification' => 'required|boolean',
            'pg_testing_mode' => 'required|boolean',
            'pg_payment_method' => 'required|string',
            'pg_reference' => 'nullable|string',
            'pg_captured' => 'required|boolean',
            'pg_card_pan' => 'nullable|string',
            'pg_card_exp' => 'nullable|string',
            'pg_card_owner' => 'nullable|string',
            'pg_card_brand' => 'nullable|string',
            'pg_auth_code' => 'nullable|string',
            'pg_salt' => 'required|string',
            'pg_sig' => 'required|string',
        ]);

        TransactionLog::create($validatedData);

        Log::info('=====================================');
        Log::info('result');
        Log::info($request);
        Log::info('=====================================');
    }
}
