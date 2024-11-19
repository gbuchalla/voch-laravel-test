<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seleciona usuários aleatórios da tabela 'users'
        $user1 = User::inRandomOrder()->first();  // Usuário aleatório para a criação
        $user2 = User::inRandomOrder()->first();  // Usuário aleatório para a atualização
        $user3 = User::inRandomOrder()->first();  // Usuário aleatório para a exclusão

        // Seleciona uma unidade aleatória da tabela 'units'
        $unit = Unit::inRandomOrder()->first();  // Pega uma unidade aleatória já existente

        // Função para gerar um CNPJ com exatamente 11 dígitos
        function generateCNPJ() {
            return str_pad(rand(10000000000, 99999999999), 11, '0', STR_PAD_LEFT);
        }

        // Auditoria para criação de Unit
        DB::table('audits')->insert([
            'auditable_type' => Unit::class,
            'auditable_id' => $unit->id,  // ID da unidade selecionada aleatoriamente
            'action' => 'created',  // Ação de criação
            'changes' => json_encode([  // Converte o array para JSON
                'old' => null,
                'new' => $unit->getAttributes()  // Dados da unidade criada
            ]),  // Alterações feitas (sem valores antigos para criação)
            'user_id' => $user1->id,  // Usuário que fez a ação (ID do usuário que criou)
            'created_at' => Carbon::now()->subDays(rand(1, 30)),  // Data aleatória nos últimos 30 dias
            'updated_at' => Carbon::now()->subDays(rand(1, 30)),  // Data aleatória
        ]);

        // Atualizando a Unit
        $unit->update([
            'fantasy_name' => 'Updated Unit ' . rand(1, 100),  // Alterando o nome
            'corporate_name' => 'Updated Corporate Unit ' . rand(1, 100),
            'cnpj' => generateCNPJ(),  // Gerando um CNPJ com 11 dígitos
        ]);

        // Auditoria para atualização de Unit
        DB::table('audits')->insert([
            'auditable_type' => Unit::class,
            'auditable_id' => $unit->id,  // ID da unidade atualizada
            'action' => 'updated',  // Ação de atualização
            'changes' => json_encode([  // Converte o array para JSON
                'old' => $unit->getOriginal(),  // Valores antigos
                'new' => $unit->getAttributes()  // Novos valores
            ]),  // Alterações feitas
            'user_id' => $user2->id,  // Usuário que fez a ação (ID do usuário que atualizou)
            'created_at' => Carbon::now()->subDays(rand(1, 30)),  // Data aleatória
            'updated_at' => Carbon::now()->subDays(rand(1, 30)),  // Data aleatória
        ]);

        // Deletando a Unit
        $unit->delete();

        // Auditoria para deleção de Unit
        DB::table('audits')->insert([
            'auditable_type' => Unit::class,
            'auditable_id' => $unit->id,  // ID da unidade deletada
            'action' => 'deleted',  // Ação de deleção
            'changes' => json_encode([  // Converte o array para JSON
                'old' => $unit->getOriginal(),  // Valores antigos
                'new' => null  // A unidade foi deletada, então os novos valores são null
            ]),  // Alterações feitas
            'user_id' => $user3->id,  // Usuário que fez a ação (ID do usuário que deletou)
            'created_at' => Carbon::now()->subDays(rand(1, 30)),  // Data aleatória
            'updated_at' => Carbon::now()->subDays(rand(1, 30)),  // Data aleatória
        ]);
    }
}
