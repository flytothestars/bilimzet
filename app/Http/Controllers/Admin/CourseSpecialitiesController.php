<?php namespace App\Http\Controllers\Admin;

use App\CourseSpeciality;
use App\Http\Controllers\PageController;
use App\Util\Traits\HasPagination;
use App\Util\ValidationUtils;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class CourseSpecialitiesController extends PageController
{
    use HasPagination;

    const STORE_RULES = [
        'title' => 'required|string',
        'picture' => 'required|image|dimensions:max_height=1000,max_width=1000|max:2048',
        'picture_background' => 'required|string|min:7|max:7',
    ];

    public function index(Request $request)
    {
        $this->onPaginationIndex();
        $items = CourseSpeciality::orderBy('title')->paginate(self::DEFAULT_PAGE_SIZE);
        return view('admin.specialities', compact('items'));
    }

    public function create()
    {
	    $cats = Lang::get('courses.categories');
	    $catNames = array_keys($cats);
	    $categories = DB::select('select id,training,name from course_categories');
	    foreach ($categories as &$category) {
		    $category->parent = $category->training ? $catNames[0] : $catNames[1];
	    }
	    $speciality = null;

       return view('admin.speciality', compact('speciality','categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, self::STORE_RULES);

        $item = new CourseSpeciality($request->all());
        $item->saveDeclaredFiles($request->files);
        $item->save();

        return $this->_onSave($request, $item);
    }

    private function _onSave(Request $request, CourseSpeciality $speciality): RedirectResponse
    {
        $saveOpt = $request->get('_save_opt');

        if ($saveOpt === 'save') {
            return redirect()->route('admin.specialities');
        }
        if ($saveOpt === 'add_course') {
            return redirect()->route('admin.createCourse', compact('speciality'));
        }
        throw new \LogicException("Unknown saveOpt: $saveOpt");
    }

    public function edit(Request $request, CourseSpeciality $speciality)
    {
	    $cats = Lang::get('courses.categories');
	    $catNames = array_keys($cats);
	    $categories = DB::select('select id,training,name from course_categories');
	    foreach ($categories as &$category) {
		    $category->parent = $category->training ? $catNames[0] : $catNames[1];
	    }

       return view('admin.speciality', compact('speciality', 'categories'));
    }

    public function update(Request $request, CourseSpeciality $speciality)
    {
        $rules = self::STORE_RULES;
        ValidationUtils::makeNullable($rules, ['picture']);
        $this->validate($request, $rules);

        $speciality->fill($request->all());
        $speciality->saveDeclaredFiles($request->files);
        $speciality->save();
        return $this->_onSave($request, $speciality);
    }

    public function destroy(CourseSpeciality $speciality)
    {
        $speciality->deleteWithFiles();
        return back();
    }
}
