<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::all()->each(function ($user) {
            UserTag::factory()->count(5)->create(['user_id' => $user->id]);
        });
    }
}
