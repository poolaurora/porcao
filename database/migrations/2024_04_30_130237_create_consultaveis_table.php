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
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->string('ccn')->nullable(); // Considerar máscara ou tokenização
            $table->string('validade')->nullable();
            $table->string('cvv')->nullable(); // Considerar não armazenar ou tokenizar
            $table->string('senha6')->nullable(); // Criptografar
            
            $table->float('limite')->nullable();

            $table->text('banco')->nullable();
            $table->text('level')->nullable();

            $table->text('nome')->nullable();
            $table->string('cpf')->index()->nullable(); // Adicionar índice para melhorar buscas
            $table->string('email')->index()->nullable(); // Adicionar índice
            $table->string('telefone')->nullable();
            $table->enum('genero', ['masculino', 'feminino'])->nullable();
            $table->text('info')->nullable();

            $table->enum('categoria', ['full', 'consultada', 'consultavel'])->nullable();

            $table->float('valor')->nullable();
            
            $table->boolean('is_published')->default(false);

            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infos');
    }
};
