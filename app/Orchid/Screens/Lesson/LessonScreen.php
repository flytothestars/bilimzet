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
            Button::make('Создать')->method('createOrUpdateLesson')->parameters([
                'courseModule' => $this->courseModule,
            ])
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
            Layout::modal('createOrEditLessonVideo', 
                    Layout::rows([
                        Input::make('lesson.id')
                            ->type('hidden'),
                        Upload::make('lesson.attachments')
                            ->multiple()
                            ->title('Видео файлы')
                            ->groups('lessonVideo'),
                    ])
            )->async('asyncGetlesson')->title('Видеоуроки')->size(Modal::SIZE_LG),
            Layout::modal('createOrEditPresent', 
                    Layout::rows([
                        Input::make('lesson.id')
                            ->type('hidden'),
                        Upload::make('lesson.attachments')
                            ->multiple()
                            ->title('Презентация файлы')
                            ->groups('lessonPresent'),
                    ])
            )->async('asyncGetlesson')->title('Презентация')->size(Modal::SIZE_LG),
        ];
    }

    public function createOrUpdateLesson(Request $request )
    {
        $count = Lesson::where('course_module_id', $request->courseModule)->count();

        $lesson = Lesson::create([
            'title' => 'Уроки ' . $count+1,
            'title_kz' => 'Сабак ' . $count+1,
            'course_module_id' => $request->courseModule
        ]);
        // $lesson->attachments()->syncWithoutDetaching(
        //     $request->input('lesson.attachments', []),
        //     $request->input('lesson.files', [])
        // );
        is_null($lesson) ? Toast::info('Модуль успешно добавлено') : Toast::info('Модуль успешно обновлено');

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
        
        Toast::info('Модуль успешно обновлен');

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
        
        Toast::info('Модуль успешно обновлен');

    }

    public function delete(Lesson $lesson)
    {
        $lesson->delete();
        Toast::info('Модуль успешно удалено');
    }

    public function asyncGetlesson(Lesson $lesson): array
    {
        $lesson->load('attachments');
        return [
            'lesson' => $lesson
        ];
    }
}
