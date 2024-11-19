<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditsTable extends Migration
{
    public function up()
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->string('auditable_type'); // Tipo da entidade (por exemplo, 'App\Models\Employee')
            $table->unsignedBigInteger('auditable_id'); // ID da entidade (por exemplo, ID do colaborador)
            $table->string('action'); // Ação realizada (create, update, delete)
            $table->text('changes')->nullable(); // Quais alterações foram feitas (se necessário)
            $table->unsignedBigInteger('user_id'); // ID do usuário que fez a alteração
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('no action')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('audits');
    }
}
