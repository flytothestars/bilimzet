<?php

namespace App\Orchid\Screens\CourseModuleLecture;

use Orchid\Screen\Screen;
use App\Http\Requests\CourseModuleLectureRequest;
use App\Orchid\Layouts\CourseModuleLecture\CourseModuleLectureListTable;
use App\Models\CourseModuleLecture;
use App\Models\CourseModule;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\Quill;

class CourseModuleLectureScreen extends Screen
{
    protected $lesson;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(int $lesson): iterable
    {
        $this->lesson = $lesson;
        return [
            'course_module_lecture_list' => CourseModuleLecture::where('lesson_id', $lesson)->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Лекции модуля';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать')->modal('createCourseModuleLecture')->method('createOrUpdateCourseModuleLecture')

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
            CourseModuleLectureListTable::class,
            Layout::modal('createCourseModuleLecture', 
                Layout::rows([
                    Input::make('courseModuleLecture.title')->title('Заголовок вопроса RU')->required(),
                    Input::make('courseModuleLecture.title_kz')->title('Заголовок вопроса KZ')->required(),
                    Quill::make('courseModuleLecture.content')->title('Содержимое RU')->required(),
                    Quill::make('courseModuleLecture.content_kz')->title('Содержимое KZ')->required(),
                    Upload::make('courseModuleLecture.attachmentsRu')
                        ->multiple()
                        ->title('Лекция файлы RU')
                        ->groups('courseModuleLectureRu'),
                    Upload::make('courseModuleLecture.attachments')
                        ->multiple()
                        ->title('Лекция файлы KZ')
                        ->groups('courseModuleLectureKz'),
                    Input::make('courseModuleLecture.lesson_id')
                        ->type('hidden')
                        ->value($this->lesson),
                ]))->title('Вопросы')->size(Modal::SIZE_LG),
            Layout::modal('editCourseModuleLecture', 
                Layout::rows([
                    Input::make('courseModuleLecture.title')->title('Заголовок вопроса RU')->required(),
                    Input::make('courseModuleLecture.title_kz')->title('Заголовок вопроса KZ')->required(),
                    Quill::make('courseModuleLecture.content')->title('Содержимое RU')->required(),
                    Quill::make('courseModuleLecture.content_kz')->title('Содержимое KZ')->required(),
                    Upload::make('courseModuleLecture.attachments')
                        ->multiple()
                        ->title('Лекция файлы RU')
                        ->groups('courseModuleLectureRu'),
                    Upload::make('courseModuleLecture.attachments')
                        ->multiple()
                        ->title('Лекция файлы KZ')
                        ->groups('courseModuleLectureKz'),
                    Input::make('courseModuleLecture.lesson_id')
                        ->type('hidden')
                        ->value($this->lesson),
                    Input::make('courseModuleLecture.id')
                        ->type('hidden')
                ]))->async('asyncGetCourseModuleLecture')->title('Вопросы')->size(Modal::SIZE_LG),
        ];
    }

    public function createOrUpdateCourseModuleLecture(CourseModuleLectureRequest $request )
    {
        $validated = $request->validated();
        $courseModuleLectureId = $request->input('courseModuleLecture.id');
        $courseModuleLecture = CourseModuleLecture::updateOrCreate([
                'id' => $courseModuleLectureId
            ], $validated['courseModuleLecture']
        );
        $courseModuleLecture->attachments()->syncWithoutDetaching(
            $request->input('courseModuleLecture.attachments', [])
        );

        is_null($courseModuleLectureId) ? Toast::info('Лекция успешно добавлено') : Toast::info('Лекция успешно обновлено');

    }

    public function delete(CourseModuleLecture $courseModuleLecture)
    {        
        $courseModuleLecture->delete();
        Toast::info('Лекция успешно удалено');
    }

    public function asyncGetCourseModuleLecture(CourseModuleLecture $courseModuleLecture): array
    {
        $courseModuleLecture->load('attachments');
        return [
            'courseModuleLecture' => $courseModuleLecture
        ];
    }
}
