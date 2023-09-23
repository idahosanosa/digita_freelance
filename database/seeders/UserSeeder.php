<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    // DB::table('users')->insert([
    //     'name' => Str::random(10),
    //     'job_title' => Str::random(10) . ' Developer',
    //     'email' => Str::random(10) . '@gmail.com',
    //     'mobile_no' => Str::random(10),
    //     'hourly_rate' => Str::random(10),
    //     'currency' => Str::random(3),
    // ]);

    // }


    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        User::factory()
            ->count(10)
            ->create();
    }
}
