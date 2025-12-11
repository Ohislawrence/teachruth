<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'type' => $this->faker->randomElement([User::TYPE_ADMIN, User::TYPE_TEACHER, User::TYPE_STUDENT]),
        ];
    }

    // Add state methods for different user types
    public function teacher()
    {
        return $this->state([
            'type' => User::TYPE_TEACHER,
        ]);
    }

    public function admin()
    {
        return $this->state([
            'type' => User::TYPE_ADMIN,
        ]);
    }

    public function student()
    {
        return $this->state([
            'type' => User::TYPE_STUDENT,
        ]);
    }
}
