<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('titre');
            $table->string('format');
            $table->date('periode_debut')->nullable();
            $table->date('periode_fin')->nullable();
            $table->json('departements')->nullable();
            $table->json('types_conge')->nullable();
            $table->string('statut')->default('brouillon');
            $table->string('regroupement')->nullable();
            $table->json('indicateurs')->nullable();
            $table->json('donnees')->nullable();
            $table->text('resume_ia')->nullable();
            $table->string('fichier_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_reports');
    }
};