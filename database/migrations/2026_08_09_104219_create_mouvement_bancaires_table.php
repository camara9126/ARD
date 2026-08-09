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
        Schema::create('mouvement_bancaires', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['virement', 'retrait', 'depot', 'versement', 'encaissement', 'autre']);
            $table->decimal('montant', 15, 2);
            $table->decimal('frais', 15, 2)->nullable();
            $table->string('motif');
            $table->string('reference');
            $table->date('date_operation');
            $table->foreignId('compte_bancaires_id')->constrained()->onDelete('cascade');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mouvement_bancaires');
    }
};
