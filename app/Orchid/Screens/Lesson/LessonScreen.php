<?php

namespace App\Orchid\Screens\Lesson;

use Orchid\Screen\Screen;
use App\Models\Lesson;
use App\Orchid\Layouts\Lesson\LessonListTable;
use App\Http\Requests\LessonRequest;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Fields\Upload;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\TextArea;
use App\Http\Requests\CourseLessonRequest;

class LessonScreen extends Screen
{
    protected $courseModule;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(int $courseModule): iterable
    {
        $this->courseModule = $courseModule;
        return [
            'lesson_list' => Lesson::where('course_module_id', $courseModule)->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Уроки';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать')->modal('createCourseLesson')->method('createOrUpdateLesson')
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
            LessonListTable::class,
            Layout::modal('createCourseLesson', 
                Layout::rows([
                    Input::make('lesson.title')->title('Заголовок вопроса RU')->required(),
                    Input::make('lesson.title_kz')->title('Заголовок вопроса KZ')->required(),
                    TextArea::make('lesson.goal')->title('Цель RU')->required(),
                    TextArea::make('lesson.goal_kz')->title('Цель KZ')->required(),
                    TextArea::make('lesson.task')->title('Задача RU')->required(),
                    TextArea::make('lesson.task_kz')->title('Задача KZ')->required(),
                    TextArea::make('lesson.result')->title('Ожидаемый результат RU')->required(),
                    TextArea::make('lesson.result_kz')->title('Ожидаемый результат KZ')->required(),
                    TextArea::make('lesson.content')->title('Содержание урока RU')->required(),
                    TextArea::make('lesson.content_kz')->title('Содержание урока KZ')->required(),
                    Input::make('lesson.course_module_id')
                            ->type('hidden')
                            ->value($this->courseModule),
                ]))->title('Урок')->size(Modal::SIZE_LG)->applyButton('Создать'),
            Layout::modal('editCourseLesson', 
                Layout::rows([
                    Input::make('lesson.title')->title('Заголовок вопроса RU')->required(),
                    Input::make('lesson.title_kz')->title('Заголовок вопроса KZ')->required(),
                    TextArea::make('lesson.goal')->title('Цель RU')->required(),
                    TextArea::make('lesson.goal_kz')->title('Цель KZ')->required(),
                    TextArea::make('lesson.task')->title('Задача RU')->required(),
                    TextArea::make('lesson.task_kz')->title('Задача KZ')->required(),
                    TextArea::make('lesson.result')->title('Ожидаемый результат RU')->required(),
                    TextArea::make('lesson.result_kz')->title('Ожидаемый результат KZ')->required(),
                    TextArea::make('lesson.content')->title('Содержание урока RU')->required(),
                    TextArea::make('lesson.content_kz')->title('Содержание урока KZ')->required(),
                    Input::make('lesson.course_module_id')
                        ->type('hidden')
                        ->value($this->courseModule),
                    Input::make('lesson.id')
                        ->type('hidden')
                ]))->title('Урок')->size(Modal::SIZE_LG)->async('asyncGetLesson'),

            Layout::modal('createOrEditVideo', 
                    Layout::rows([
                        Input::make('lesson.id')
                            ->type('hidden'),
                        Upload::make('lesson.attachments')
                            ->multiple()
                            ->title('Видео файлы RU')
                            ->groups('lessonVideoRu'),
                        Upload::make('lesson.attachments')
                            ->multiple()
                            ->title('Видео файлы KZ')
                            ->groups('lessonVideoKz'),
                    ])
            )->async('asyncGetLesson')->title('Видеоуроки')->size(Modal::SIZE_LG),
            Layout::modal('createOrEditPresent', 
                    Layout::rows([
                        Input::make('lesson.id')
                            ->type('hidden'),
                        Upload::make('lesson.attachments')
                            ->multiple()
                            ->title('Презентация файлы RU')
                            ->groups('lessonPresentRu'),
                        Upload::make('lesson.attachments')
                            ->multiple()
                            ->title('Презентация файлы KZ')
                            ->groups('lessonPresentKz'),
                    ])
            )->async('asyncGetLesson')->title('Презентация')->size(Modal::SIZE_LG),
        ];
    }

    public function createOrUpdateLesson(CourseLessonRequest $request )
    {
        $validated = $request->validated();
        $lessonId = $request->input('lesson.id');
        $lesson = Lesson::updateOrCreate([
                'id' => $lessonId
            ], $validated['lesson']
        );
        $lesson->attachments()->syncWithoutDetaching(
            $request->input('lesson.attachments', [])
        );

        is_null($lessonId) ? Toast::info('Урок успешно добавлено') : Toast::info('Урок успешно обновлено');

    }

    public function createOrEditLessonVideo(Request $request)
    {
        $lesson = Lesson::find($request->input('lesson.id'));
        $lesson->attachments()->syncWithoutDetaching(
            $request->input('lesson.attachments', [])
        );
        $lesson->load('attachments');
        $lesson->update([
            'is_video' => $lesson->attachments->isEmpty() ? 0 : 1
        ]);
        
        Toast::info('Урок успешно обновлен');

    }

    public function createOrEditLessonPresent(Request $request)
    {
        $lesson = Lesson::find($request->input('lesson.id'));
        $lesson->attachments()->syncWithoutDetaching(
            $request->input('lesson.attachments', [])
        );
        $lesson->load('attachments');
        $lesson->update([
            'is_present' => $lesson->attachments->isEmpty() ? 0 : 1
        ]);
        
        Toast::info('Урок успешно обновлен');

    }

    public function delete(Lesson $lesson)
    {
        $lesson->delete();
        Toast::info('Урок успешно удалено');
    }

    public function asyncGetLesson(Lesson $lesson): array
    {
        $lesson->load('attachments');
        return [
            'lesson' => $lesson
        ];
    }
}
