<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table des cotisations (paiements) des membres.
     */
    public function up(): void
    {
        Schema::create('cotisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained('membres')->cascadeOnDelete();
            $table->string('reference', 40)->unique()->comment('Généré automatiquement : REC-2026-0001');
            $table->decimal('montant', 12, 2);
            $table->unsignedTinyInteger('mois')->comment('1 à 12');
            $table->unsignedSmallInteger('annee');
            $table->date('date_paiement');
            $table->enum('mode_paiement', ['Espèces', 'Wave', 'Orange Money', 'Virement']);
            $table->string('observation')->nullable();
            $table->timestamps();

            $table->unique(['membre_id', 'mois', 'annee'], 'uniq_membre_periode');
            $table->index(['mois', 'annee']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotisations');
    }
};
