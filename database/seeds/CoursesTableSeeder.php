<?php

use App\Course;
use App\CoursePart;
use App\CourseSpeciality;
use App\CourseTest;
use App\CourseTestResult;
use App\Data\CourseSpecialityCategories;
use App\User;
use Carbon\CarbonInterface;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    const DAY_IN_SECONDS = 60 * 60 * 24;
    const TEST_QUESTIONS = 4;

    /* @var \Faker\Generator $faker */
    private $faker;

    /* @var object $images */
    private $images;

    /* @var CarbonInterface $date */
    private $date;

    /*  @var User[] $users */
    private $users;


    public function run()
    {
        $this->faker = \Faker\Factory::create();
        $this->images = $this->prepareImages();
        $this->date = \Carbon\Carbon::create(2019);
        $this->users = User::where('is_demo', true)->get();
        CourseSpeciality::query()->delete();

        $coursesData = $this->getCoursesData();
        foreach ($coursesData as $category) {
            foreach ($category->cats as $subcategory) {
                $fullCategoryName = CourseSpecialityCategories::makeCategory($category->name, $subcategory->name);
                foreach ($subcategory->items as $courseData) {
                    $speciality = $this->createSpeciality($fullCategoryName, $courseData);
                    for ($i = 0; $i < mt_rand(1, 3); $i++) {
                        $this->generateCourse($speciality, $i);
                    }
                }
            }
        }
    }

    private function prepareImages()
    {
        return [
            'authorImages' => $this->prepareAuthorImages(),
            'courseImages' => $this->prepareCourseImages()
        ];
    }

    private function getCoursesData()
    {
        $path = base_path('stub') . DIRECTORY_SEPARATOR . 'courses_data.json';
        $text = file_get_contents($path);
        return json_decode($text);
    }

    private function prepareAuthorImages()
    {
        $imagesDir = base_path('stub') . DIRECTORY_SEPARATOR . 'authors';
        $pathList = glob($imagesDir . DIRECTORY_SEPARATOR . '*.jpg');
        return Course::getPublicUploadsDir()->copyFiles($pathList);
    }

    private function prepareCourseImages(): array
    {
        $imagesDir = public_path('images') . DIRECTORY_SEPARATOR . 'courses';
        $pathList = glob($imagesDir . DIRECTORY_SEPARATOR . '*.svg');
        return Course::getPublicUploadsDir()->copyFiles($pathList);
    }

    private function createSpeciality($category, $courseData): CourseSpeciality
    {
        $speciality = new CourseSpeciality();
        $speciality->is_demo = true;
        $speciality->category = $category;
        $speciality->title = $courseData->title;
        $speciality->picture = $courseData->image;
        $speciality->picture_background = $courseData->background;
        $speciality->save();
        return $speciality;
    }

    private function generateCourse(CourseSpeciality $speciality, $i)
    {
        $course = new Course();
        $course->is_demo = true;
        $course->speciality_id = $speciality->id;
        $course->title = $speciality->title . ' - Курс №' . ($i + 1);
        $course->author_fio = $this->faker->name;
        $course->author_position = $this->faker->sentence(4);
        $course->author_photo = $this->faker->randomElement($this->images['authorImages']);
        $course->desc_text = $this->makeDescText();
        $course->listeners_category_text = '<p>' . $this->faker->paragraph(5) . '</p>';
        $course->goals_text = '<p>' . $this->faker->paragraph(6) . '</p>';
        $course->tasks_text = $this->makeTasksText();
        $course->organization_text = $this->makeOrganizationText();
        $course->save();

        for ($i = 0; $i < mt_rand(3, 5); $i++) {
            $this->generateCoursePart($course);
        }

        for ($i = 0; $i < mt_rand(1, 3); $i++) {
            $this->generateTest($course);
        }

        $this->date->addDay();
    }

    private function generateTest(Course $course)
    {
        $test = new CourseTest([
            'title' => $this->faker->sentence,
            'duration_minutes' => 1
        ]);
        $course->tests()->save($test);

        $questions = factory(\App\CourseTestQuestion::class, self::TEST_QUESTIONS)->make();
        $test->questions()->saveMany($questions);

        for ($i = 0; $i < mt_rand(1, 3); $i++) {
            $this->generateTestResult($test);
        }

    }

    private function generateTestResult(CourseTest $test)
    {
        $date = $this->date->clone();
        $date->addSeconds(mt_rand(0, self::DAY_IN_SECONDS - 1));
        $minAnswers = round(self::TEST_QUESTIONS / 3);
        $correctAnswers = mt_rand($minAnswers, self::TEST_QUESTIONS);

        CourseTestResult::create([
            'finished_at' => $date,
            'correct_answers' => $correctAnswers,
            'total_answers' => self::TEST_QUESTIONS,
            'user_id' => $this->faker->randomElement($this->users)->id,
            'course_test_id' => $test->id,
        ]);
    }

    private function generateCoursePart(Course $course)
    {
        $part = new CoursePart();
        $part->duration_hours = mt_rand(10, 70);
        $part->price_kzt = mt_rand(10000, 40000);
        $part->plan = $this->generateCoursePartPlan($course->title);
        $part->file = $this->generateCoursePartFile($course->title);
        $course->parts()->save($part);
    }

    private function generateCoursePartPlan($title): string
    {
        $BOM = "\xEF\xBB\xBF";
        $text = "План для курса \"$title\":\n\n" . $this->faker->paragraph(15);
        $uploads = CoursePart::getPublicUploadsDir();
        $fileName = $uploads->generateName('txt');
        $path = $uploads->getPathFor($fileName);

        $fp = fopen($path, 'w');
        fwrite($fp, $BOM);
        fwrite($fp, $text);
        fclose($fp);
        return $fileName;
    }

    private function generateCoursePartFile($title): string
    {
        $text = "Полезное содержимое курса \"$title\":\n\n" . $this->faker->text(2000);
        $uploads = CoursePart::getPrivateUploadsDir();
        $fileName = $uploads->generateName('txt');
        $path = $uploads->getPathFor($fileName);
        file_put_contents($path, $text);
        return $fileName;
    }

    private function makeDescText(): string
    {
        return sprintf("<p>%s</p>\n<p>%s</p>",
            $this->faker->paragraph(3), $this->faker->paragraph(7));
    }

    private function makeTasksText(): string
    {
        $res = "";
        for ($i = 1; $i <= 8; $i++) {
            $res .= "<p> $i) " . $this->faker->sentence(10) . "</p>\n";
        }
        return $res;
    }

    private function makeOrganizationText(): string
    {
        $res = "";
        for ($i = 1; $i <= 4; $i++) {
            $res .= "<p>" . $this->faker->paragraph(mt_rand(4, 8)) . "</p>\n";
        }
        return $res;
    }

}
