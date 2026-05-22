<?php

// database/factories/UserFactory.php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition()
    {
        $faker = \Faker\Factory::create('fr_FR');

        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password'),
        ];
    }
}