<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cotisations', function (Blueprint $table) {
            $table->dropColumn(['observation', 'mode_paiement']);
        });
    }

    public function down(): void
    {
        Schema::table('cotisations', function (Blueprint $table) {
            $table->enum('mode_paiement', ['Espèces', 'Wave', 'Orange Money', 'Virement']);
            $table->string('observation')->nullable();
        });
    }
};