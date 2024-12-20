<?php

namespace App\Orchid\Screens\CourseQuestion;

use Orchid\Screen\Screen;
use App\Models\CourseQuestion;
use App\Orchid\Layouts\CourseQuestion\CourseQuestionListTable;
use App\Http\Requests\CourseQuestionRequest;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Layouts\Modal;

class CourseQuestionScreen extends Screen
{
    protected $courseTest;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(int $courseTest): iterable
    {
        $this->courseTest = $courseTest;
        return [
            'course_question_list' => CourseQuestion::where('course_test_id', $courseTest)->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Вопросы';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать')->modal('createCourseQuestion')->method('createOrUpdateCourseQuestion')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            CourseQuestionListTable::class,
            Layout::modal('createCourseQuestion', 
                Layout::rows([
                    Input::make('courseQuestion.title')->title('Заголовок вопроса RU')->required(),
                    Input::make('courseQuestion.title_kz')->title('Заголовок вопроса KZ')->required(),
                    Input::make('courseQuestion.correct_answer')->title('Правильный ответ RU')->required(),
                    Input::make('courseQuestion.correct_answer_kz')->title('Правильный ответ KZ')->required(),
                    Input::make('courseQuestion.incorrect_answer_1')->title('Неправильный ответ №1 RU')->required(),
                    Input::make('courseQuestion.incorrect_answer_1_kz')->title('Неправильный ответ №1 KZ')->required(),
                    Input::make('courseQuestion.incorrect_answer_2')->title('Неправильный ответ №2 RU')->required(),
                    Input::make('courseQuestion.incorrect_answer_2_kz')->title('Неправильный ответ №2 KZ')->required(),
                    Input::make('courseQuestion.incorrect_answer_3')->title('Неправильный ответ №3 RU')->required(),
                    Input::make('courseQuestion.incorrect_answer_3_kz')->title('Неправильный ответ №3 KZ')->required(),
                    Input::make('courseQuestion.course_test_id')
                        ->type('hidden')
                        ->value($this->courseTest),
                ]))->title('Вопросы')->size(Modal::SIZE_LG),
            Layout::modal('editCourseQuestion', 
                Layout::rows([
                    Input::make('courseQuestion.title')->title('Заголовок вопроса RU')->required(),
                    Input::make('courseQuestion.title_kz')->title('Заголовок вопроса KZ')->required(),
                    Input::make('courseQuestion.correct_answer')->title('Правильный ответ RU')->required(),
                    Input::make('courseQuestion.correct_answer_kz')->title('Правильный ответ KZ')->required(),
                    Input::make('courseQuestion.incorrect_answer_1')->title('Неправильный ответ №1 RU')->required(),
                    Input::make('courseQuestion.incorrect_answer_1_kz')->title('Неправильный ответ №1 KZ')->required(),
                    Input::make('courseQuestion.incorrect_answer_2')->title('Неправильный ответ №2 RU')->required(),
                    Input::make('courseQuestion.incorrect_answer_2_kz')->title('Неправильный ответ №2 KZ')->required(),
                    Input::make('courseQuestion.incorrect_answer_3')->title('Неправильный ответ №3 RU')->required(),
                    Input::make('courseQuestion.incorrect_answer_3_kz')->title('Неправильный ответ №3 KZ')->required(),
                    Input::make('courseQuestion.course_test_id')
                        ->type('hidden')
                        ->value($this->courseTest),
                    Input::make('courseQuestion.id')
                        ->type('hidden')
                ]))->async('asyncGetCourseQuestion')->title('Вопросы')->size(Modal::SIZE_LG),
        ];
    }

    public function createOrUpdateCourseQuestion(CourseQuestionRequest $request )
    {
        $validated = $request->validated();
        $courseQuestionId = $request->input('courseQuestion.id');
        $courseQuestion = CourseQuestion::updateOrCreate([
            'id' => $courseQuestionId
        ], $validated['courseQuestion']
        );
        is_null($courseQuestionId) ? Toast::info('Вопрос успешно добавлено') : Toast::info('Вопрос успешно обновлено');

    }

    public function delete(CourseQuestion $courseQuestion)
    {
        $courseQuestion->delete();
        Toast::info('Вопрос успешно удалено');
    }

    public function asyncGetCourseQuestion(CourseQuestion $courseQuestion): array
    {
        return [
            'courseQuestion' => $courseQuestion
        ];
    }
}
