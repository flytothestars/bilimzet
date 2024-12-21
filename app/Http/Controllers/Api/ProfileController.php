<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\ApiResponseHelper;
use App\Http\Resources\ProfileResource;
use App\Http\Requests\ProfileRequest;
use Orchid\Screen\Fields\Upload;
use Orchid\Attachment\File;
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

        $user->fill($request->collect()->except(['photo', 'diplomas','password', 'permissions', 'roles'])->toArray())
            ->forceFill(['permissions' => $permissions])
            ->save();

        $user->replaceRoles($role);
        
        // Files
        // photo
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->photo));
        $tmpFile = tmpfile();
        $tmpFilePath = stream_get_meta_data($tmpFile)['uri'];
        file_put_contents($tmpFilePath, $imageData);
        $fileRequest = new \Illuminate\Http\UploadedFile($tmpFilePath, 'profile_photo.png', 'image/png', null, true);
        $file = new File($fileRequest, null,'profilePhoto');
        $attachmentPhoto = $file->load();
        $user->attachments()->syncWithoutDetaching(
            $attachmentPhoto->id
        );
        unlink($tmpFilePath);
        
        // documents
        $file = new File($request->file('diplomas'), null,'profileDocument');
        $attachment = $file->load();
        $user->attachments()->syncWithoutDetaching(
            $attachment->id
        );
        
        return ApiResponseHelper::success(new ProfileResource($user));
    }
}
