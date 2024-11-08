<?php namespace App;

use App\Data\RunningTest;
use Illuminate\Database\Eloquent\Model;

class CourseTestResult extends Model
{
    public $timestamps = false;

    protected $dates = [ 'finished_at' ];

    public static function createFrom(RunningTest $runningTest)
    {
        $result = new CourseTestResult();
        $result->finished_at = $runningTest->getFinishedTime();
        $result->correct_answers = $runningTest->getCorrectAnswers();
        $result->total_answers = $runningTest->getQuestionsTotal();
        $result->user_id = auth()->user()->id;
        $result->course_test_id = $runningTest->getId();
        $result->save();
    }

    public function getPrettyResult()
    {
        return sprintf('%d / %d',
            $this->correct_answers, $this->total_answers);
    }

    public function test()
    {
        return $this->belongsTo('App\CourseTest', 'course_test_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function certificate()
    {
        return $this->hasOne('App\Certificate', 'result_id');
    }
}
