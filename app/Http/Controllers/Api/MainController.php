<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Helper\ApiResponseHelper;

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
}
