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
        Schema::create('equipements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unite_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->decimal('valeur_achat', 15, 2);
            $table->integer('duree_vie_annees');
            $table->date('date_mise_service');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipements');
    }
};
