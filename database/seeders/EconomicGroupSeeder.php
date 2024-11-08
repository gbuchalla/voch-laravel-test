<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class EconomicGroupSeeder extends Seeder
{
    /**
     * Gera seeds para o banco de dados.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create(locale:'pt_BR');
        
        // Define o número de grupos econômicos a criar
        $numberOfGroups = 2;

        for ($i = 0; $i < $numberOfGroups; $i++) {
            DB::table('economic_groups')->insert($this->generateEconomicGroupData($faker));
        }
    }

    /**
     * Gera dados para um grupo econômico.
     *
     * @param \Faker\Generator $faker
     * @return array
     */
    private function generateEconomicGroupData($faker)
    {
        $createdAt = Carbon::now()->subDays(rand(0, 3 * 365));
        $updatedAt = $createdAt->copy()->addDays(rand(0, 365));

        return [
            'name' => $faker->company,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}

