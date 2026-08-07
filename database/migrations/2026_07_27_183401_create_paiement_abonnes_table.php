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
        Schema::create('paiement_abonnes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('abonne_id')->constrained()->onDelete('cascade');
            $table->string('mois');
            $table->string('annee');
            $table->decimal('montant', 15, 2)->nullable();
            $table->string('statut');
            $table->date('date_paiement')->nullable();
            $table->string('valide_par')->nullable();
            $table->string('reference_paiement')->nullable();
            $table->enum('mode_paiement', ['cash','wave','orange_money','cheque','autre'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiement_abonnes');
    }
};
