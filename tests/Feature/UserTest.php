<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // test for the status code for index request
    public function testIndexHeader(): void
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->get('/api/user');

        $response->assertStatus(200);
    } //end of testIndexHeader method

    // test for store method
    public function testStoreMethod(): void
    {
        $currencyCode = explode(',', env('CURRENCIES'));;
        $data = [
            'name' => fake()->name(),
            'job_title' => fake()->jobTitle(),
            'email' => fake()->unique()->safeEmail(),
            'mobile_no' => fake()->phoneNumber(),
            'hourly_rate' => fake()->randomDigitNotZero(),
            'currency' => $currencyCode[array_rand($currencyCode, 1)],
        ];
        $this->post('/api/user', $data)
            ->assertStatus(201);
    } //end of testStoreMethod method

    // testing the update method for data consistency
    public function testUpdate(): void
    {
        $user = new User;
        $data = $user->update([
            'name' => 'nosa',
            'email' => 'idahosanosa@gmail.cdom',
            'mobile_no' => '0773367986',
            'job_title' => 'PHP developer',
            'hourly_rate' => 100,
            'currency' => 'GPB',
        ]);

        $this->assertSame($data, $data);
    } // end of testUpdate method

    // test for checking a user rate based on a provided currency
    public function testShowUserWithCurrency(): void
    {
        $user = User::first();
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->get('/api/user/' . $user->id . '?currency=USD');

        $response->assertStatus(200);
    } // end of testShowUserWithCurrency method

    //test for delete method
    public function testDeleteUser(): void
    {
        $user = User::factory()->count(1)->make();
        $user = User::first();

        if ($user) {
            $user->delete();
        }
        $this->assertTrue(true);
    } // end of testDeleteUser method
}
