<?php namespace App;

use App\Data\CourseSpecialityCategories;
use App\Util\Traits\HasUploads;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class CourseSpeciality extends Model
{
    use HasUploads;

    const UPLOADS_DIR_NAME = 'courses';

    const FILES = [ 'picture' ];

    protected $fillable = [ 'title', 'title_kz', 'category', 'picture_background' ];

    public function getParentCategory()
    {
	    $categories = Lang::get('courses.categories');
	    $categoryNames = array_keys($categories);
	    $cats = DB::select('select id,training from course_categories where id = ?', [ $this->category ]);

       return $cats[0]->training ? $categoryNames[0] : $categoryNames[1];
    }

    public function getChildCategory()
    {
	    $categories = Lang::get('courses.categories');
	    $categoryNames = array_keys($categories);
	    $locale = Lang::getLocale();
	    $name = 'name' . ($locale == 'kz' ? '_kz' : '');
	    $cats = DB::select('select id,' . $name . ' from course_categories where id = ?', [ $this->category ]);

	    return $locale == 'kz' ? $cats[0]->name_kz : $cats[0]->name;
    }

//    public static function getSplittedBySubcategories($parentCategoryName)
//    {
//	    $categories = Lang::get('courses.categories');
//
//        if (!isset($categories[$parentCategoryName])) {
//            throw new \LogicException("Unknown parent category name: $parentCategoryName");
//        }
//        $subcategoryNames = $categories[$parentCategoryName];
//        $specialities = CourseSpeciality::where('category', 'like', "$parentCategoryName^%")->get();
//        $result = [];
//        foreach ($subcategoryNames as $subcategoryName) {
//            $result[$subcategoryName] = [];
//            $fullCategoryName = CourseSpecialityCategories::makeCategory($parentCategoryName, $subcategoryName);
//            foreach ($specialities as $speciality) {
//                if ($speciality->category === $fullCategoryName) {
//                    $result[$subcategoryName][] = $speciality;
//                }
//            }
//        }
//        return $result;
//    }

    public function courses()
    {
        return $this->hasMany('App\Course', 'speciality_id');
    }
}
