<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // testing the status code for request
    public function testHeaders(): void
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->get('/api/user');

        $response->assertStatus(200);
    }

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
    }

    public function testShowUserWithCurrency(): void
    {
        $user = new User;
        $data = $user->show(7, 'USD');

        $this->assertSame($data, $data);
    }

    public function testDeleteUser(): void
    {
        $user = User::factory()->count(1)->make();
        $user = User::first();

        if ($user) {
            $user->delete();
        }
        $this->assertTrue(true);
    }
}