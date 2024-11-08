<?php

use App\User;
use App\Util\Phpbb;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PhpbbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Phpbb::createUser('user123@mail.me', '123123');
    }
}
