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
        Schema::create('produit_intrants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unite_id')->constrained()->onDelete('cascade');
            $table->string('designation');
            $table->foreignId('produit_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('quantite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit_intrants');
    }
};
