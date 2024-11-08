<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            CoursesTableSeeder::class,
            CourseTestimonialsTableSeeder::class
        ]);

        // Run manually after forum configured:
        // php artisan db:seed --class=PhpbbSeeder
    }
}
