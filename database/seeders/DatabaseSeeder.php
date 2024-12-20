<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(EconomicGroupSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(EmployeeSeeder::class);

        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password'

        ]);
    }
}
