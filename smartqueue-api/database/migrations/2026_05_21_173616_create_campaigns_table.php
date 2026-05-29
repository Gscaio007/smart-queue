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
    Schema::create('campaigns', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nome do lote, ex: "Desconto de Inauguração"
        $table->string('subject')->nullable(); // Assunto (caso seja enviado por e-mail)
        $table->text('content'); // Corpo da mensagem
        $table->string('status')->default('pending'); // 'pending', 'processing', 'completed'
        $table->integer('total_recipients')->default(0); // Quantos contatos vieram na lista
        $table->integer('processed_recipients')->default(0); // Quantos já foram enviados
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
