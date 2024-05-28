<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reembolsos', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade'); // Chave estrangeira para a tabela `users`
            $table->string('description'); // Campo para texto descritivo
            $table->string('status')->default('pendente'); // Status do reembolso
            $table->string('chave_pix'); // Chave PIX para o reembolso
            $table->timestamps(); // Campos `created_at` e `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reembolsos');
    }
};
