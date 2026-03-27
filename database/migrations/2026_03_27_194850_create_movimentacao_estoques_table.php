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
        Schema::create('movimentacoes_estoque', function (Blueprint $table) {
            $table->id();

            $table->foreignId('produto_id')->constrained('produtos')->cascadeOnDelete();
            
            // O tipo da movimentação: entrada ou saída
            $table->enum('tipo', ['entrada', 'saida']);
            
            // Quantidade movimentada
            $table->integer('quantidade');
            
            // Um motivo (ex: "Compra", "Ajuste", "Devolução")
            $table->string('observacao')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacao_estoques');
    }
};
