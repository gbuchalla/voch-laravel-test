<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class UnitSeeder extends Seeder
{
    /**
     * Gera seeds para o banco de dados.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create(locale: 'pt_BR');

        // Define o número de unidades a criar
        $numberOfUnits = 10;

        for ($i = 0; $i < $numberOfUnits; $i++) {
            DB::table('units')->insert($this->generateUnitsData($faker));
        }
    }

    /**
     * Gera dados para uma Unidade.
     *
     * @param \Faker\Generator $faker
     * @return array
     */
    private function generateUnitsData($faker)
    {
        $brand = DB::table('brands')->inRandomOrder()->first();

        $company = $faker->company;
        // Verificar se o Faker já gerou um sufixo para nome da empresa.
        $companyHasSuffix = !strrpos($company, 'S.A.') && !strpos($company, 'Ltda.'); 
        // Escolhe um sufixo caso não tenha sido gerado pelo Faker
        $CompanySuffix = $companyHasSuffix ? $CompanySuffix = ['S.A.', 'Ltda.'][array_rand(['S.A.', 'Ltda.'])] : null;

        $createdAt = Carbon::now()->subDays(rand(0, 3 * 365));
        $updatedAt = $createdAt->copy()->addDays(rand(0, 365));

        return [
            'fantasy_name' => $company,
            'corporate_name' => $companyHasSuffix ? "{$company} {$CompanySuffix}" : $company,
            'cnpj' => $faker->cnpj(false),
            'brand_id' => $brand->id,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
