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
        Schema::table('paiement_abonnes', function (Blueprint $table) {
            $table->date('date_paiement')->nullable()->change();
            $table->string('valide_par')->nullable()->change();
            $table->string('reference_paiement')->nullable()->change();
            $table->string('mode_paiement')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paiement_abonnes', function (Blueprint $table) {
            $table->date('date_paiement')->nullable(false)->change();
            $table->string('valide_par')->nullable(false)->change();
            $table->string('reference_paiement')->nullable(false)->change();
            $table->string('mode_paiement')->nullable(false)->change();
        });
    }
};
