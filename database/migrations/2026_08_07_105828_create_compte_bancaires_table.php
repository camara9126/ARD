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
        Schema::create('compte_bancaires', function (Blueprint $table) {
            $table->id();
            $table->string('banque');
            $table->string('numero_compte');
            $table->string('titulaire');
            $table->decimal('solde_initial', 15, 2);
            $table->date('date_ouverture');
            $table->enum('statut', ['actif', 'inactif'])->default('actif');
            $table->foreignId('unite_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compte_bancaires');
    }
};
