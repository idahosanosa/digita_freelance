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

    public function testHeaders(): void
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->get('/api/user');

        $response->assertStatus(200);
    }

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
}
