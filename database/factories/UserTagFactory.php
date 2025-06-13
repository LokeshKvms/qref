<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserTag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserTag>
 */
class UserTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = UserTag::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->unique()->word(),
        ];
    }
}
