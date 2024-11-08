<?php

use App\Course;
use App\CourseTestimonial;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseTestimonialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseTestimonial::where('is_demo', true)->delete();

        $courses = Course::where('is_demo', true)->get();
        $users = User::where('is_demo', true)->get();
        $faker = \Faker\Factory::create();

        foreach ($courses as $course) {
            $authors = $faker->randomElements($users, 5);
            foreach ($authors as $author) {
                $this->createTestimonial($course, $author, $faker);
            }
        }
    }

    private function createTestimonial(Course $course, User $user, \Faker\Generator $faker)
    {
        $testimonial = new CourseTestimonial();
        $testimonial->is_demo = true;
        $testimonial->text = $faker->paragraph;
        $testimonial->course_id = $course->id;
        $testimonial->user_id = $user->id;
        $testimonial->created_at = Carbon::now()->subMinutes(mt_rand(0, 10000));
        $testimonial->updated_at = $testimonial->created_at;
        $testimonial->save();
    }
}
