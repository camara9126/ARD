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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unite_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('montant', 15, 2);
            $table->enum('mode_paiement', ['cash','wave','orange_money','cheque','autre']);
            $table->string('reference')->unique();
            $table->date('date_paiement');      
            $table->enum('statut', ['valide', 'annule'])->default('valide');
            $table->text('motif')->nullable();
            $table->unsignedBigInteger('annule_par')->nullable();
            $table->timestamp('annule_le')->nullable();      
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
