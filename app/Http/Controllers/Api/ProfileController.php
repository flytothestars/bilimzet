<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\ApiResponseHelper;
use App\Http\Resources\ProfileResource;
use App\Http\Requests\ProfileRequest;
use App\Models\CourseTestResult;
use Orchid\Attachment\File;
use App\Models\CourseBuy;
use App\Models\Course;
use App\Models\CoursePart;
use App\Http\Controllers\Api\CourseController;

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
        $filePhoto = new File($fileRequest, null,'profilePhoto');
        $attachmentPhoto = $filePhoto->load();
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
        $user->is_verification = true;
        return ApiResponseHelper::success(new ProfileResource($user));
    }

    public function certificate(){
        $user = auth()->user()->id;
        $results = CourseTestResult::where('user_id', $user)->where('status_certificate', 2)->get();
        $data = [];
        foreach($results as $result){
            $data[] = [
                'url_link' => url('storage/cert-'.$result->user_id.'-'.$result->id.'-'.$result->rand.'.pdf'),
                'name' => $result->coursePart->course->speciality->title,
                'date' => $result->updated_at,
            ];

        }
        return ApiResponseHelper::success($data);

    }

    public function course()
    {
        $user = auth()->user()->id;
        $courseBuy = CourseBuy::where('user_id', $user)->get()->map(function($courseBuy){
            $courseBuy->course = Course::where('id', $courseBuy->course_id)->first();
            $courseBuy->part = CoursePart::where('id', $courseBuy->course_part_id)->first();
            $courseBuy->test = [
                'passed' => 0,
                'limit' => 2,
                'test' => true
            ];
            $courseController = new CourseController();
            $process = $courseController->courseProcess($courseBuy->course_part_id, $courseBuy->course_id);
            $courseBuy->process = $process->original['data'];
            return $courseBuy;
        });
        return ApiResponseHelper::success($courseBuy);
    }
}
