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
    Schema::create('recipients', function (Blueprint $table) {
        $table->id();
        // Chave estrangeira indexada ligando ao lote da campanha
        $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('destination'); // O e-mail ou número de telefone
        $table->string('status')->default('pending'); // 'pending', 'sent', 'failed'
        $table->text('error_message')->nullable(); // Caso a API de disparo falhe, guardamos o motivo aqui
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipients');
    }
};
