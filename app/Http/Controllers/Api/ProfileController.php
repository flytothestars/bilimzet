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
use App\Models\UserNotifications;
use App\Models\CoursePart;
use App\Http\Controllers\Api\CourseController;
use App\Models\CourseSpeciality;
use App\Helper\Helper;
use Orchid\Attachment\Models\Attachment;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function get()
    {
        $user = auth()->user(); 
        $user->photo = $user->attachment('profilePhoto')->first();
        if ($user->photo) {
            $user->photo->link = url($user->photo->relativeUrl);
        }
        $user->diploma = $user->attachment('profileDocument')->get();
        $user->diploma->map(function($item){
            $item->link = url($item->relativeUrl);
            return $item;
        });
        return ApiResponseHelper::success($user);
    }

    public function update(Request $request)
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
        // dd('asd');
        $role = [2]; //User

        $user->fill($request->collect()->except(['photo', 'diplomas','password', 'permissions', 'roles'])->toArray())
            ->forceFill(['permissions' => $permissions])
            ->save();

        $user->replaceRoles($role);
        
        // Files
        // photo
        if ($request->photo) {
            $isPhoto = $user->attachments('profilePhoto')->get();
            foreach ($isPhoto as $key => $photo) {
                if ($photo->id) {
                    $attachment = Attachment::find($photo->id);
                    if ($attachment) {
                        $attachment->delete();
                    }
                }
            }
            
            $file = new File($request->file('photo'), null,'profilePhoto');
            $attachment = $file->load();
            $user->attachments()->syncWithoutDetaching(
                $attachment->id
            );
        }
        
        // documents
        if($request->file('diplomas')){
            $isDocuments = $user->attachments('profileDocument')->get();
            foreach ($isDocuments as $key => $document) {
                if ($document->id) {
                    $attachment = Attachment::find($document->id);
                    if ($attachment) {
                        $attachment->delete();
                    }
                }
            }
            
            if ($request->hasFile('diplomas')) {
                $attachments = [];
            
                $file = $request->file('diplomas');
                foreach ($request->file('diplomas') as $uploadedFile) {
                    $file = new File($uploadedFile, null, 'profileDocument');
                    $attachment = $file->load();
                    $attachments[] = $attachment->id;
                }
                
                $user->attachments()->syncWithoutDetaching($attachments);
            }

            // $file = new File($request->file('diplomas'), null,'profileDocument');
            // $attachment = $file->load();
            // $user->attachments()->syncWithoutDetaching(
            //     $attachment->id
            // );
        }
        
        $user->is_verification = true;
        $user->save();
        $user->photo = $user->attachment('profilePhoto')->first();
        if ($user->photo) {
            $user->photo->link = url($user->photo->relativeUrl);
        }
        $user->diploma = $user->attachment('profileDocument')->get();
        $user->diploma->map(function($item){
            $item->link = url($item->relativeUrl);
            return $item;
        });

        return ApiResponseHelper::success($user);
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
            $speciality = CourseSpeciality::where('id', $courseBuy->course->speciality_id)->first();
            $courseBuy->picture = Helper::getUrls($speciality);
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

    public function deleteDocument($document_id){
        $attachment = Attachment::find($document_id);
        if ($attachment) {
            $attachment->delete();
            return ApiResponseHelper::success();
        }
        return ApiResponseHelper::error();
    }

    public function notification(){
        $user = auth()->user(); 
        return ApiResponseHelper::success([
            'notifications' => $user->notifications()->orderBy('created_at', 'desc')->get(),
            'read_count' => $user->read_notifications_count,
            'unread_count' => $user->unread_notifications_count
        ]);
    }

    public function deleteNotification(Request $request){
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer'
        ]);
        $noti = UserNotifications::whereIn('id', $request->ids)->delete();
        return ApiResponseHelper::success();
    }

    public function updateNotification(Request $request){
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer'
        ]);
        $noti = UserNotifications::whereIn('id', $request->ids)->update(['is_read' => true]);
        return ApiResponseHelper::success();
    }

}
