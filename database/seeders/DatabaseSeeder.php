<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(5)->create();

        \App\Models\User::factory()->create([
            'name' => 'basel',
            'email' => 'baselebido@gmail.com',
            'verification_code' => '0000',
            'mobile' => '+972592270122',
            'password' => 'asd01251dasd5',
            'identity_number' => '154661565',
            'remember_token' => Str::random(10),
        ]);
    }
}
