<?php

namespace App\Orchid\Screens\CourseModule;

use Orchid\Screen\Screen;
use App\Models\CourseModule;
use App\Orchid\Layouts\CourseModule\CourseModuleListTable;
use App\Http\Requests\CourseModuleRequest;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Fields\Upload;

class CourseModuleScreen extends Screen
{
    protected $coursePart;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(int $coursePart): iterable
    {
        $this->coursePart = $coursePart;
        return [
            'course_module_list' => CourseModule::where('course_part_id', $coursePart)->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Модули';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать')->modal('createCourseModule')->method('createOrUpdateCourseModule')
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
            CourseModuleListTable::class,
            Layout::modal('createCourseModule', 
                Layout::rows([
                    Input::make('courseModule.title')->title('Заголовок вопроса RU')->required(),
                    Input::make('courseModule.title_kz')->title('Заголовок вопроса KZ')->required(),
                    Input::make('courseModule.text')->title('Текст описание RU')->required(),
                    Input::make('courseModule.text_kz')->title('Текст описание KZ')->required(),
                    Input::make('courseModule.lecture')->title('Описание лекции RU')->required(),
                    Input::make('courseModule.lecture_kz')->title('Описание лекции KZ')->required(),
                    Upload::make('courseModule.attachments')
                        ->title('Лекция')
                        ->groups('courseModuleLecture'),
                    Upload::make('courseModule.files')
                        ->multiple()
                        ->title('Видео файлы')
                        ->groups('courseModuleVideo'),
                    Input::make('courseModule.course_part_id')
                        ->type('hidden')
                        ->value($this->coursePart),
                ]))->title('Вопросы')->size(Modal::SIZE_LG),
            Layout::modal('editCourseModule', 
                Layout::rows([
                    Input::make('courseModule.title')->title('Заголовок вопроса RU')->required(),
                    Input::make('courseModule.title_kz')->title('Заголовок вопроса KZ')->required(),
                    Input::make('courseModule.text')->title('Текст описание RU')->required(),
                    Input::make('courseModule.text_kz')->title('Текст описание KZ')->required(),
                    Input::make('courseModule.lecture')->title('Описание лекции RU')->required(),
                    Input::make('courseModule.lecture_kz')->title('Описание лекции KZ')->required(),
                    Upload::make('courseModule.attachments')
                        ->title('Лекция')
                        ->groups('courseModuleLecture'),
                    Upload::make('courseModule.files')
                        ->multiple()
                        ->title('Видео файлы')
                        ->groups('courseModuleVideo'),
                    Input::make('courseModule.course_part_id')
                        ->type('hidden')
                        ->value($this->coursePart),
                    Input::make('courseModule.id')
                        ->type('hidden')
                ]))->async('asyncGetCourseModule')->title('Вопросы')->size(Modal::SIZE_LG),
        ];
    }

    public function createOrUpdateCourseModule(CourseModuleRequest $request )
    {
        $validated = $request->validated();
        $courseModuleId = $request->input('courseModule.id');
        $courseModule = CourseModule::updateOrCreate([
                'id' => $courseModuleId
            ], $validated['courseModule']
        );
        $courseModule->attachments()->syncWithoutDetaching(
            $request->input('courseModule.attachments', []),
            $request->input('courseModule.files', [])
        );
        is_null($courseModuleId) ? Toast::info('Модуль успешно добавлено') : Toast::info('Модуль успешно обновлено');

    }

    public function delete(CourseModule $courseModule)
    {
        $courseModule->delete();
        Toast::info('Модуль успешно удалено');
    }

    public function asyncGetCourseModule(CourseModule $courseModule): array
    {
        $courseModule->load('attachments');
        return [
            'courseModule' => $courseModule
        ];
    }
}
