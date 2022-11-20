<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(100)->create();

        \App\Models\User::factory()->create([
            'name' => 'Mario',
            'email' => 'mario.carranza996@gmail.com',
            'password' => '$2y$10$lAnM9O0GWY07pLRAYVltPep/6UEwpdXRJf.il66sdq3n13cd6PDrS'
        ]);
    }
}
