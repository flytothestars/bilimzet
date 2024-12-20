<?php

namespace App\Orchid\Screens\CourseTest;

use Orchid\Screen\Screen;
use App\Models\CourseTest;
use Orchid\Screen\Actions\ModalToggle;
use App\Orchid\Layouts\CourseTest\CourseTestListTable;
use App\Models\CoursePart;
use App\Http\Requests\CourseTestRequest;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Fields\Relation;

class CourseTestScreen extends Screen
{
    protected $course;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(int $course): iterable
    {
        $this->course = $course;
        return [
            'course_test_list' => CourseTest::where('course_id', $course)->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Тест';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать')->modal('createCourseTest')->method('createOrUpdateCourseTest')
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
            CourseTestListTable::class,
            Layout::modal('createCourseTest', 
                Layout::rows([
                    Input::make('courseTest.title')->title('Название RU')->required(),
                    Input::make('courseTest.title_kz')->title('Название KZ')->required(),
                    Input::make('courseTest.duration_minutes')->title('Время выполнения (минут)')->required(),
                    Relation::make('courseTest.course_part_id')->fromModel(CoursePart::class, 'title')->title('Часть курса')->required(),
                    Input::make('courseTest.course_id')
                        ->type('hidden')
                        ->value($this->course),
                ])->title('Основной информация'),
            )
            ->title('Создать часть курса')
            ->applyButton('Создать')
            ->size(Modal::SIZE_LG),

            Layout::modal('editCourseTest',
                Layout::rows([
                    Input::make('courseTest.title')->title('Название курса RU')->required(),
                    Input::make('courseTest.title_kz')->title('Название курса KZ')->required(),
                    Input::make('courseTest.duration_minutes')->title('Время выполнения (минут)')->required(),
                    Relation::make('courseTest.course_part_id')->fromModel(CoursePart::class, 'title')->title('Часть курса')->required(),
                    Input::make('courseTest.course_id')
                        ->type('hidden')
                        ->value($this->course),
                    Input::make('courseTest.id')->type('hidden'),
                ])->title('Часть курса'),
            )->async('asyncGetСourseTest')->size(Modal::SIZE_LG),

        ];
    }

    public function createOrUpdateCourseTest(CourseTestRequest $request )
    {
        $validated = $request->validated();
        $courseTestId = $request->input('courseTest.id');
        $courseTest = CourseTest::updateOrCreate([
            'id' => $courseTestId
        ], $validated['courseTest']);
        is_null($courseTestId) ? Toast::info('Часть курса успешно добавлено') : Toast::info('Часть курса успешно обновлено');

    }

    public function delete(CourseTest $courseTest)
    {
        $courseTest->delete();
        Toast::info('Часть курса успешно удалено');
    }

    public function asyncGetСourseTest(CourseTest $courseTest): array
    {
        return [
            'courseTest' => $courseTest
        ];
    }
}
