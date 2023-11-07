<?php

namespace Database\Seeders;


use App\Domain\Delegation\Models\Delegation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Delegation::factory(10)->create();
    }
}
