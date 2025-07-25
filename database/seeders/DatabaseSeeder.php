<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            GameCategorySeeder::class,
            UserSeeder::class,
            GameSeeder::class,
            CreditCardSeeder::class,
        ]);
    }
}