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
        Schema::create('charge_fixes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unite_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('designation');
            $table->string('intitulait');
            $table->text('description')->nullable();
            $table->decimal('montant', 15, 2);
            $table->date('date_debut');
            $table->date('date_fin');
            $table->enum('periode', ['journalier', 'hebdomadaire', 'mensuel', 'trimestriel', 'annuel'])->default('mensuel');
            $table->enum('statut', ['active', 'inactive'])->default('active');              
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charge_fixes');
    }
};
