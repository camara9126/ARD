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
        Schema::create('abonnes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unite_id')->constrained()->onDelete('cascade');
            $table->string('nom_complet');
            $table->string('reference')->unique();
            $table->string('telephone');
            $table->string('adresse');
            $table->date('date_abonnement');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonnes');
    }
};
