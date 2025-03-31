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
use Illuminate\Http\Request;

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
                    Input::make('courseModule.title')->title('Заголовок модуля RU')->required(),
                    Input::make('courseModule.title_kz')->title('Заголовок модуля KZ')->required(),
                    Input::make('courseModule.duration_hours')->title('Длительность (академических часов)')->required(),

                    // Input::make('courseModule.goal')->title('Цель RU')->required(),
                    // Input::make('courseModule.goal_kz')->title('Цель KZ')->required(),
                    // Input::make('courseModule.task')->title('Задача RU')->required(),
                    // Input::make('courseModule.task_kz')->title('Задача KZ')->required(),
                    // Input::make('courseModule.result')->title('Ожидаемый результат RU')->required(),
                    // Input::make('courseModule.result_kz')->title('Ожидаемый результат KZ')->required(),
                    // Input::make('courseModule.content')->title('Содержание урока RU')->required(),
                    // Input::make('courseModule.content_kz')->title('Содержание урока KZ')->required(),
                    Input::make('courseModule.course_part_id')
                        ->type('hidden')
                        ->value($this->coursePart),
                ]))->title('Модуль')->size(Modal::SIZE_LG),
            Layout::modal('editCourseModule', 
                Layout::rows([
                    Input::make('courseModule.title')->title('Заголовок модуля RU')->required(),
                    Input::make('courseModule.title_kz')->title('Заголовок модуля KZ')->required(),
                    Input::make('courseModule.duration_hours')->title('Длительность (академических часов)')->required(),
                    // Input::make('courseModule.goal')->title('Цель RU')->required(),
                    // Input::make('courseModule.goal_kz')->title('Цель KZ')->required(),
                    // Input::make('courseModule.task')->title('Задача RU')->required(),
                    // Input::make('courseModule.task_kz')->title('Задача KZ')->required(),
                    // Input::make('courseModule.result')->title('Ожидаемый результат RU')->required(),
                    // Input::make('courseModule.result_kz')->title('Ожидаемый результат KZ')->required(),
                    // Input::make('courseModule.content')->title('Содержание урока RU')->required(),
                    // Input::make('courseModule.content_kz')->title('Содержание урока KZ')->required(),
                    Input::make('courseModule.course_part_id')
                        ->type('hidden')
                        ->value($this->coursePart),
                    Input::make('courseModule.id')
                        ->type('hidden')
                ]))->async('asyncGetCourseModule')->title('Модуль')->size(Modal::SIZE_LG),

            // Layout::modal('createOrEditVideo', 
            //         Layout::rows([
            //             Input::make('courseModule.id')
            //                 ->type('hidden'),
            //             Upload::make('courseModule.attachments')
            //                 ->multiple()
            //                 ->title('Видео файлы')
            //                 ->groups('courseModuleVideo'),
            //         ])
            // )->async('asyncGetCourseModule')->title('Видеоуроки')->size(Modal::SIZE_LG),
            // Layout::modal('createOrEditPresent', 
            //         Layout::rows([
            //             Input::make('courseModule.id')
            //                 ->type('hidden'),
            //             Upload::make('courseModule.attachments')
            //                 ->multiple()
            //                 ->title('Презентация файлы')
            //                 ->groups('courseModulePresent'),
            //         ])
            // )->async('asyncGetCourseModule')->title('Презентация')->size(Modal::SIZE_LG),
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

    public function createOrEditCourseModuleVideo(Request $request)
    {
        $courseModule = CourseModule::find($request->input('courseModule.id'));
        $courseModule->attachments()->syncWithoutDetaching(
            $request->input('courseModule.attachments', [])
        );
        $courseModule->load('attachments');
        $courseModule->update([
            'is_video' => $courseModule->attachments->isEmpty() ? 0 : 1
        ]);
        
        Toast::info('Модуль успешно обновлен');

    }

    public function createOrEditCourseModulePresent(Request $request)
    {
        $courseModule = CourseModule::find($request->input('courseModule.id'));
        $courseModule->attachments()->syncWithoutDetaching(
            $request->input('courseModule.attachments', [])
        );
        $courseModule->load('attachments');
        $courseModule->update([
            'is_present' => $courseModule->attachments->isEmpty() ? 0 : 1
        ]);
        
        Toast::info('Модуль успешно обновлен');

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
