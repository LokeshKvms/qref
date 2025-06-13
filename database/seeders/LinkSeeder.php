<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Tag;
use App\Models\User;
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
        $user = User::first();

        // Make sure some tags exist
        $tags = Tag::all();

        $links = Link::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);

        // Attach 1–3 random tags to each link
        foreach ($links as $link) {
            $link->tags()->attach(
                $tags->random(rand(1, min(3, $tags->count())))->pluck('id')->toArray()
            );
        }
    }
}
