<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();


        // php artisan db:seed
        User::create( [
            'name' => 'admin',
            "password"=>Hash::make("12345678"),
            // "name"=>"Super Admin"
        ]);
    }
}
