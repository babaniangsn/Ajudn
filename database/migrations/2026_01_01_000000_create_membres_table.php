<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table des membres de l'association.
     */
    public function up(): void
    {
        Schema::create('membres', function (Blueprint $table) {
            $table->id();
            $table->string('matricule', 20)->unique()->comment('Généré automatiquement : MB-0001');
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('adresse')->nullable();
            $table->date('date_adhesion');
            $table->enum('statut', ['actif', 'inactif'])->default('actif');
            $table->timestamps();

            $table->index(['nom', 'prenom']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membres');
    }
};
