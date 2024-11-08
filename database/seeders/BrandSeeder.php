<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class BrandSeeder extends Seeder
{
    /**
     * Gera seeds para o banco de dados.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create(locale:'pt_BR');

        // Define o número de bandeiras a criar
        $numberOfBrands = 5;

        for ($i = 0; $i < $numberOfBrands; $i++) {
            DB::table('brands')->insert($this->generateBrandsData($faker));
        }
    }

    /**
     * Gera dados para uma Bandeira.
     *
     * @param \Faker\Generator $faker
     * @return array
     */
    private function generateBrandsData($faker)
    {
        $economic_group = DB::table('economic_groups')->inRandomOrder()->first();

        $createdAt = Carbon::now()->subDays(rand(0, 3 * 365));
        $updatedAt = $createdAt->copy()->addDays(rand(0, 365));

        return [
            'name' => $faker->company(),
            'economic_group_id' => $economic_group->id,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}