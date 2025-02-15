<?php

namespace App\Orchid\Screens\Course;

use App\Models\Course;
use App\Orchid\Layouts\Course\CourseListTable;
use Orchid\Screen\Screen;
use App\Http\Requests\CourseRequest;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Fields\TextArea;

class CourseScreen extends Screen
{
    protected $courseSpeciality;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(int $courseSpeciality): iterable
    {
        $this->courseSpeciality = $courseSpeciality;
        return [
            'course_list' => Course::where('speciality_id', $courseSpeciality)->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Курсы';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать курс')->modal('createCourse')->method('createOrUpdateCourse')
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
            CourseListTable::class,
            Layout::modal('createCourse', 
                [
                    Layout::rows([
                        Input::make('course.title')->title('Название курса RU')->required(),
                        Input::make('course.title_kz')->title('Название курса KZ')->required(),
                        Input::make('course.form_training')->title('Форма обучение')->required(),
                        Input::make('course.form_training_kz')->title('Форма обучение KZ')->required(),
                        Input::make('course.valid_period')->title('Срок действительности')->required(),
                        Input::make('course.valid_period_kz')->title('Срок действительности KZ')->required(),
                        Input::make('course.issuance_certificate')->title('Выдача сертификата')->required(),
                        Input::make('course.issuance_certificate_kz')->title('Выдача сертификата KZ')->required(),
                        Input::make('course.certificate_text')->title('Сертификаты')->required(),
                        Input::make('course.certificate_text_kz')->title('Сертификаты KZ')->required(),
                        Input::make('course.speciality_id')
                            ->type('hidden')
                            ->value($this->courseSpeciality),
                    ])->title('Курс'),
                    Layout::rows([
                        Input::make('course.author_fio')->title('ФИО автора RU')->required(),
                        Input::make('course.author_fio_kz')->title('ФИО автора KZ')->required(),
                        Input::make('course.author_position')->title('Должность автора RU')->required(),
                        Input::make('course.author_position_kz')->title('Должность автора KZ')->required(),
                        Upload::make('course.attachments')
                            ->title('Фото автора')
                            ->groups('courseAuthorPhoto')
                            ->required(),
                    ])->title('Автор'),
                    Layout::rows([
                        TextArea::make('course.desc_text')->title('Описание курса RU')->required()->rows(10),
                        TextArea::make('course.desc_text_kz')->title('Описание курса KZ')->required()->rows(10),
                        TextArea::make('course.listeners_category_text')->title('Категория слушателей RU')->required()->rows(10),
                        TextArea::make('course.listeners_category_text_kz')->title('Категория слушателей KZ')->required()->rows(10),
                        TextArea::make('course.goals_text')->title('Цели курса RU')->required()->rows(10),
                        TextArea::make('course.goals_text_kz')->title('Цели курса KZ')->required()->rows(10),
                        TextArea::make('course.tasks_text')->title('Задачи курса RU')->required()->rows(10),
                        TextArea::make('course.tasks_text_kz')->title('Задачи курса KZ')->required()->rows(10),
                        TextArea::make('course.organization_text')->title('Организация образовательного процесса, формы и методы, оценка результатов RU')->required()->rows(10),
                        TextArea::make('course.organization_text_kz')->title('Организация образовательного процесса, формы и методы, оценка результатов KZ')->required()->rows(10),
                    ])->title('Подробности'),
                ]
            )
            ->title('Создать курс')
            ->applyButton('Создать')
            ->size(Modal::SIZE_LG),

            Layout::modal('editCourse', [
                Layout::rows([
                    Input::make('course.title')->title('Название курса RU')->required(),
                    Input::make('course.title_kz')->title('Название курса KZ')->required(),
                    Input::make('course.form_training')->title('Форма обучение')->required(),
                    Input::make('course.form_training_kz')->title('Форма обучение KZ')->required(),
                    Input::make('course.valid_period')->title('Срок действительности')->required(),
                    Input::make('course.valid_period_kz')->title('Срок действительности KZ')->required(),
                    Input::make('course.issuance_certificate')->title('Выдача сертификата')->required(),
                    Input::make('course.issuance_certificate_kz')->title('Выдача сертификата KZ')->required(),
                    Input::make('course.certificate_text')->title('Сертификаты')->required(),
                    Input::make('course.certificate_text_kz')->title('Сертификаты KZ')->required(),
                    Input::make('course.id')->type('hidden'),
                    Input::make('course.speciality_id')
                            ->type('hidden')
                            ->value($this->courseSpeciality),
                ])->title('Курс'),
                Layout::rows([
                    Input::make('course.author_fio')->title('ФИО автора RU')->required(),
                    Input::make('course.author_fio_kz')->title('ФИО автора KZ')->required(),
                    Input::make('course.author_position')->title('Должность автора RU')->required(),
                    Input::make('course.author_position_kz')->title('Должность автора KZ')->required(),
                    Upload::make('course.attachments')
                        ->title('Фото автора')
                        ->groups('courseAuthorPhoto')
                        ->required(),
                ])->title('Автор'),
                Layout::rows([
                    TextArea::make('course.desc_text')->title('Описание курса RU')->required()->rows(10),
                    TextArea::make('course.desc_text_kz')->title('Описание курса KZ')->required()->rows(10),
                    TextArea::make('course.listeners_category_text')->title('Категория слушателей RU')->required()->rows(10),
                    TextArea::make('course.listeners_category_text_kz')->title('Категория слушателей KZ')->required()->rows(10),
                    TextArea::make('course.goals_text')->title('Цели курсаRU')->required()->rows(10),
                    TextArea::make('course.goals_text_kz')->title('Цели курсаKZ')->required()->rows(10),
                    TextArea::make('course.tasks_text')->title('Задачи курса RU')->required()->rows(10),
                    TextArea::make('course.tasks_text_kz')->title('Задачи курса KZ')->required()->rows(10),
                    TextArea::make('course.organization_text')->title('Организация образовательного процесса, формы и методы, оценка результатов RU')->required()->rows(10),
                    TextArea::make('course.organization_text_kz')->title('Организация образовательного процесса, формы и методы, оценка результатов KZ')->required()->rows(10),
                ])->title('Подробности'),
            ])->async('asyncGetСourse')->size(Modal::SIZE_LG),

        ];
    }

    public function createOrUpdateCourse(CourseRequest $request )
    {
        $validated = $request->validated();
        $courseId = $request->input('course.id');
        $course = Course::updateOrCreate([
            'id' => $courseId
        ], $validated['course']);
        $course->attachments()->syncWithoutDetaching(
            $request->input('course.attachments', [])
        );
        is_null($courseId) ? Toast::info('Курс успешно добавлено') : Toast::info('Курс успешно обновлено');

    }

    public function delete(Course $course)
    {
        $course->delete();
        Toast::info('Курс успешно удалено');
    }

    public function asyncGetСourse(Course $course): array
    {
        $course->load('attachments');
        return [
            'course' => $course
        ];
    }
}
