<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    /**
     * Gera seeds para o banco de dados.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create(locale:'pt_BR');

        // Define o número de colaboradores a criar
        $numberOfEmployees = 100;

        for ($i = 0; $i < $numberOfEmployees; $i++) {
            DB::table('employees')->insert($this->generateEmployeesData($faker));
        }
    }

    /**
     * Gera dados para um Colaborador.
     *
     * @param \Faker\Generator $faker
     * @return array
     */
    private function generateEmployeesData($faker)
    {
        $unit = DB::table('units')->inRandomOrder()->first();
        $firstName = $faker->firstName;
        $lastName = $faker->lastName;

        $createdAt = Carbon::now()->subDays(rand(0, 3 * 365));
        $updatedAt = $createdAt->copy()->addDays(rand(0, 365));

        return [
            'name' => "{$firstName} {$lastName}",
            'email' => strtolower($firstName) . "." . strtolower($lastName) . "@gmail.com",
            'cpf' => $faker->cpf(false),
            'unit_id' => $unit->id,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
