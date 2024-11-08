<?php

namespace App\Http\Controllers\Admin\Olympic;

use App\Http\Controllers\PageController;
use App\Models\Olympic\OlympicAnswer;
use App\Models\Olympic\OlympicClassification;
use App\Models\Olympic\OlympicCourse;
use App\Models\Olympic\OlympicMember;
use App\Models\Olympic\OlympicQuestion;
use App\Models\Olympic\OlympicSubject;
use App\Util\Traits\HasPagination;
use Illuminate\Http\Request;

class CoursesController extends PageController
{
    use HasPagination;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = OlympicCourse::with(['classification', 'member', 'subject'])->paginate(20);

        return view('admin.olympic.courses.index', [
            'courses' => $courses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classifications = OlympicClassification::all();
        $members = OlympicMember::all();
        $subjects = OlympicSubject::all();

        return view('admin.olympic.courses.create', compact(
            'classifications',
            'members',
            'subjects'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $course = OlympicCourse::create([
            'classification_id' => $request->classification,
            'member_id' => $request->member,
            'subject_id' => $request->subject,
            'title' => $request->title,
            'price' => $request->price,
            'locale' => $request->locale,
        ]);

        foreach ($request->question as $question) {
            $questionNew = OlympicQuestion::create([
                'course_id' => $course->id,
                'question' => $question['title']
            ]);

            $right_answer = $question['right_answer'];
           foreach ($question['answers'] as $key => $answer) {
               $is_right_answer = $key == $right_answer;

               OlympicAnswer::create([
                   'question_id' => $questionNew->id,
                   'answer' => $answer,
                   'is_right' => $is_right_answer
               ]);
           }
        }

        return redirect(route('admin.olympic.courses.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $classifications = OlympicClassification::all();
        $members = OlympicMember::all();
        $subjects = OlympicSubject::all();

        $course = OlympicCourse::findOrFail($id);

        return view('admin.olympic.courses.edit', compact(
            'classifications',
            'members',
            'subjects',
            'course'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $course = OlympicCourse::where('id', $id)
            ->update([
                'classification_id' => $request->classification,
                'member_id' => $request->member,
                'subject_id' => $request->subject,
                'title' => $request->title,
                'price' => $request->price,
                'locale' => $request->locale,
            ]);

        foreach ($request->question as $keyQ => $question) {
			   if (isset($question['is_new']) && $question['is_new'] == 1) {
					$questionNew = OlympicQuestion::create([
						'course_id' => $id,
						'question' => $question['title']
					]);

					$right_answer = $question['right_answer'];
					foreach ($question['answers'] as $key => $answer) {
						$is_right_answer = $key == $right_answer;

						OlympicAnswer::create([
							'question_id' => $questionNew->id,
							'answer' => $answer,
							'is_right' => $is_right_answer
						]);
					}
				} else {
					$questionNew = OlympicQuestion::where('id', $keyQ)
						->update([
							'question' => $question['title']
						]);



					if (!isset($question['right_answer'])) {
						$right_answer = $request['is_right'][$keyQ];
					} else {
						$right_answer = (int)$question['right_answer'][0] ?? (int)$question['right_answer'];
					}

					foreach ($question['answers'] as $keyA => $answer) {
						$is_right_answer = $keyA == $right_answer;

						OlympicAnswer::where('id', $keyA)
							->update([
								'answer' => $answer,
								'is_right' => $is_right_answer
							]);
					}
				}
        }

        return redirect(route('admin.olympic.courses.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OlympicCourse $course)
    {
        $course->delete();

        return back();
    }

	 public function deleteQuestion(Request $request)
	 {
		 $q = OlympicQuestion::findOrFail((int) $request->id);

		 $q->answers()->delete();

		 $q->delete();

		 return back();
	 }
}
