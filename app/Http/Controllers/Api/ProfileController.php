<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\ApiResponseHelper;
use App\Http\Resources\ProfileResource;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function get()
    {
        $profile = auth()->user(); 
        return ApiResponseHelper::success(new ProfileResource($profile));
    }

    public function update(ProfileRequest $request)
    {
		$user = auth()->user();
        
        if (!$user) {
            return ApiResponseHelper::error('User not found', 404);
        }

        $permissions = [
            "platform.systems.attachment" => "1",
            "platform.systems.users" => "1",
            "platform.systems.roles" => "0",
            "platform.index" => "1"
        ];

        $role = [2]; //User
        
        $user
            ->fill($request->collect()->except(['password', 'permissions', 'roles'])->toArray())
            ->forceFill(['permissions' => $permissions])
            ->save();

        $user->replaceRoles($role);

		// $this->updateFile($user, 'photo', $request);
		// $this->updateFile($user, 'diploma', $request);

        return ApiResponseHelper::success(new ProfileResource($user));
    }
}