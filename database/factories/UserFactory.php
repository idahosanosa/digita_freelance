<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Testing\Fakes\Fake;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        //get the currency symbols from the env file
        $currencyCode = explode(',', env('CURRENCIES'));;

        return [
            'name' => fake()->name(),
            'job_title' => fake()->jobTitle(),
            'email' => fake()->unique()->safeEmail(),
            'mobile_no' => fake()->phoneNumber(),
            'hourly_rate' => fake()->randomDigitNotZero(),
            'currency' => $currencyCode[array_rand($currencyCode, 1)],
        ];
    }




    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}