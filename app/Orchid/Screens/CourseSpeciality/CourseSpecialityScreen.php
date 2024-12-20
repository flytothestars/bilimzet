<?php

namespace App\Orchid\Screens\CourseSpeciality;

use App\Models\CourseSpeciality;
use App\Orchid\Layouts\CourseSpeciality\CourseSpecialityListTable;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\Relation;
use App\Http\Requests\CourseSpecialityRequest;
use App\Models\Category;
use Orchid\Screen\Layouts\Modal;

class CourseSpecialityScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'course_speciality_list' => CourseSpeciality::paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Специализации';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать cпециализации')->modal('createCourseSpeciality')->method('createOrUpdateCourseSpeciality')
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
            CourseSpecialityListTable::class,
            Layout::modal('createCourseSpeciality', Layout::rows([
                Input::make('courseSpeciality.title')->title('Заголовка RU')->required(),
                Input::make('courseSpeciality.title_kz')->title('Заголовка KZ')->required(),
                Relation::make('courseSpeciality.category')->fromModel(Category::class, 'name')->displayAppend('full')->title('Категория')->required(),
                Input::make('courseSpeciality.picture_background')
                        ->type('color')
                        ->title('Color Picker')
                        ->value('#563d7c')
                        ->horizontal(),
                Upload::make('courseSpeciality.attachments')
                    ->title('Картинка')
                    ->required(),
            ]))->title('Создать cпециализации')->applyButton('Создать')->size(Modal::SIZE_LG),
            
            Layout::modal('editCourseSpeciality', Layout::rows([
                Input::make('courseSpeciality.id')->type('hidden'),
                Input::make('courseSpeciality.title')->title('Заголовка RU')->required(),
                Input::make('courseSpeciality.title_kz')->title('Заголовка KZ')->required(),
                Relation::make('courseSpeciality.category')->fromModel(Category::class, 'name')->displayAppend('full')->title('Категория')->required(),
                Input::make('courseSpeciality.picture_background')
                        ->type('color')
                        ->title('Color Picker')
                        ->value('#563d7c')
                        ->horizontal(),
                Upload::make('courseSpeciality.attachments')
                    ->title('Картинка')
                    ->required(),
            ]))->async('asyncGetCourseSpeciality')->size(Modal::SIZE_LG),
        ];
    }

    public function createOrUpdateCourseSpeciality(CourseSpecialityRequest $request )
    {
        $validated = $request->validated();
        
        $courseSpecialityId = $request->input('courseSpeciality.id');
        $courseSpeciality = CourseSpeciality::updateOrCreate([
            'id' => $courseSpecialityId
        ], $validated['courseSpeciality']);
        $courseSpeciality->attachments()->syncWithoutDetaching(
            $request->input('courseSpeciality.attachments', [])
        );
        is_null($courseSpecialityId) ? Toast::info('Cпециализации успешно добавлено') : Toast::info('Cпециализации успешно обновлено');

    }

    public function delete(CourseSpeciality $courseSpeciality)
    {
        $courseSpeciality->delete();
        Toast::info('Cпециализации успешно удалено');
    }

    public function asyncGetCourseSpeciality(CourseSpeciality $courseSpeciality): array
    {
        $courseSpeciality->load('attachments');
        return [
            'courseSpeciality' => $courseSpeciality
        ];
    }
}
