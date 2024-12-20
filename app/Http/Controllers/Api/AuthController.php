<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helper\ApiResponseHelper;
use App\Services\Sms\MobizonService;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    const SECRET_KEY = 'bilimzet';

    protected $mobizonService;

    public function __construct(MobizonService $mobizonService)
    {
        $this->mobizonService = $mobizonService;
    }

    public function send(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);
        if($this->mobizonService->send($request->phone))
        {
            return ApiResponseHelper::success();
        }

        return ApiResponseHelper::error();
    }

    public function verify(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'code'  => 'required|string'
        ]);
        
        if($this->mobizonService->verify($request->phone, $request->code))
        {
            // return ApiResponseHelper::success('Verification successful');
            return ApiResponseHelper::success($this->login($request->phone));
        }
        return ApiResponseHelper::error('Verification failed');
    }

    public function token(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return ApiResponseHelper::error(['status' => 'error', 'message' => 'Token not provided'], 400);
        }

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            return ApiResponseHelper::error(['status' => 'error', 'message' => 'Invalid token'], 401);
        }

        if ($accessToken->expires_at && now()->greaterThan($accessToken->expires_at)) {
            return ApiResponseHelper::error(['status' => 'expired', 'message' => 'Token has expired'], 401);
        }

        return ApiResponseHelper::success(['status' => 'active', 'message' => 'Token is valid']);
    }

    public function login($phone)
    {
        $user = User::where('phone', $phone)->first();

        if(! $user)
        {
            $user = $this->register($phone);
        }

        if (!Hash::check($this->secret($phone), $user->password))
        {
            return 'The provided credentials are incorrect.';
        }
        
        $token = $user->createToken('auth_token')->plainTextToken;
        return ['access_token' => $token, 'token_type' => 'Bearer'];
    }

    public function register($phone)
    {
        return User::create([
            'name'      => $this->generateName(),
            'phone'     => $phone,
            'password'  => Hash::make($this->secret($phone)),
        ]);
    }

    private function secret($phone)
    {
        return self::SECRET_KEY . $phone;
    }

    private function generateName()
    {
        return 'name_' . '_' . rand(1000, 9999);
    }

}
