<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('fantasy_name');
            $table->string('corporate_name')->unique();
            $table->string('cnpj', 14)->unique(); // CNPJ com 14 dígitos considerando símbolos (. e -)
            $table->unsignedBigInteger('brand_id')->nullable();

            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
