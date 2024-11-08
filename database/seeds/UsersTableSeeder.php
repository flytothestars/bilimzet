<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::where('type', '!=', User::ADMIN_TYPE)->delete();
        $this->prepareImages();
        try {
            User::create([
                'name' => 'admin',
                'email' => 'admin@vshat.me',
                'password' => Hash::make('Aou32JNdmZSOnsgKLgzo'),
                'full_name' => 'Admin',
                'address' => '@',
                'photo' => 'admin.png',
                'type' => User::ADMIN_TYPE
            ]);
        } catch (PDOException $exception) {
            // pass
        }

        for ($i = 1; $i < 10; $i++) {
            User::create([
                'name' => "user $i",
                'email' => "user$i@mail.me",
                'password' => Hash::make('123123'),
                'full_name' => "ФИО $i",
                'address' => "Адрес $i",
                'company_name' => "Компания $i",
                'phone' => "+7123456789$i",
                'position' => "Должность $i",
                'photo' => 'bot.png',
                'is_demo' => true,
            ]);
        }
    }

    private function prepareImages()
    {
        $imagesDir = base_path('stub') . DIRECTORY_SEPARATOR . 'avatars';
        $pathList = glob($imagesDir . DIRECTORY_SEPARATOR . '*.png');
        return User::getUploadsDir()->copyFiles($pathList);
    }
}
