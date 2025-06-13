<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = User::factory(10)->create();
        $globalTags = Tag::factory(10)->create();

        $users->each(function ($user) use ($globalTags) {
            $userTags = UserTag::factory(5)->create(['user_id' => $user->id]);

            Link::factory(5)->create(['user_id' => $user->id])->each(function ($link) use ($globalTags, $userTags) {
                $link->globalTags()->attach($globalTags->random(rand(1, 3))->pluck('id')->toArray());
                $link->userTags()->attach($userTags->random(rand(1, 2))->pluck('id')->toArray());
            });
        });
    }
}
