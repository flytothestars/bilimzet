<?php

namespace App\Orchid\Screens\CoursePart;

use App\Models\CoursePart;
use App\Orchid\Layouts\CoursePart\CoursePartListTable;
use Orchid\Screen\Screen;
use App\Http\Requests\CoursePartRequest;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Layouts\Modal;
class CoursePartScreen extends Screen
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
            'course_part_list' => CoursePart::where('course_id', $course)->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Части курса';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать')->modal('createCoursePart')->method('createOrUpdateCoursePart')
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
            CoursePartListTable::class,
            Layout::modal('createCoursePart', 
                Layout::rows([
                    Input::make('coursePart.title')->title('Название курса RU')->required(),
                    Input::make('coursePart.title_kz')->title('Название курса KZ')->required(),
                    Input::make('coursePart.duration_hours')->title('Длительность (академических часов)')->required(),
                    Input::make('coursePart.price_kzt')->title('Стоимость (тенге)')->required(),
                    Upload::make('coursePart.attachments')
                        ->title('План')
                        ->groups('coursePartPlan')
                        ->required(),
                    Input::make('coursePart.course_id')
                        ->type('hidden')
                        ->value($this->course),
                ])->title('Курс'),
            )
            ->title('Создать часть курса')
            ->applyButton('Создать')
            ->size(Modal::SIZE_LG),

            Layout::modal('editCoursePart',
                Layout::rows([
                    Input::make('coursePart.title')->title('Название курса RU')->required(),
                    Input::make('coursePart.title_kz')->title('Название курса KZ')->required(),
                    Input::make('coursePart.duration_hours')->title('Длительность (академических часов)')->required(),
                    Input::make('coursePart.price_kzt')->title('Стоимость (тенге)')->required(),
                    Upload::make('coursePart.attachments')
                        ->title('План')
                        ->groups('coursePartPlan')
                        ->required(),
                    Input::make('coursePart.course_id')
                        ->type('hidden')
                        ->value($this->course),
                    Input::make('coursePart.id')->type('hidden'),
                ])->title('Часть курса'),
            )->async('asyncGetСourse')->size(Modal::SIZE_LG),

        ];
    }

    public function createOrUpdateCoursePart(CoursePartRequest $request )
    {
        $validated = $request->validated();
        $coursePartId = $request->input('coursePart.id');
        $coursePart = CoursePart::updateOrCreate([
            'id' => $coursePartId
        ], $validated['coursePart']);
        $coursePart->attachments()->syncWithoutDetaching(
            $request->input('coursePart.attachments', [])
        );
        is_null($coursePartId) ? Toast::info('Часть курса успешно добавлено') : Toast::info('Часть курса успешно обновлено');

    }

    public function delete(CoursePart $coursePart)
    {
        $coursePart->delete();
        Toast::info('Часть курса успешно удалено');
    }

    public function asyncGetСourse(CoursePart $coursePart): array
    {
        $coursePart->load('attachments');
        return [
            'coursePart' => $coursePart
        ];
    }
}
