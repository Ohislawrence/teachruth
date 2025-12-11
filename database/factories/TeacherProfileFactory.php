<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\TeacherProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherProfileFactory extends Factory
{
    protected $model = TeacherProfile::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'qualification' => $this->faker->randomElement(['B.Ed', 'M.Ed', 'PGDE', 'PhD in Education']),
            'years_of_experience' => $this->faker->numberBetween(1, 20),
            'specialization' => $this->faker->randomElement(['Mathematics', 'Science', 'English', 'History', 'Computer Science']),
            'state' => $this->faker->state(),
            'lga' => $this->faker->city(),
            'bio' => $this->faker->paragraph(3),
            'phone' => $this->faker->phoneNumber(),
            'is_public' => true,
        ];
    }
}
