<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();

            // L'employé qui fait la demande
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Type de congé
            $table->enum('type', ['paye', 'maladie', 'sans_solde'])->default('paye');

            // Dates de la demande
            $table->date('date_debut');
            $table->date('date_fin');

            // Nombre de jours (calculé côté formulaire ou automatiquement)
            $table->unsignedSmallInteger('jours');

            // Statut de validation
            $table->enum('statut', ['en_attente', 'approuve', 'refuse'])->default('en_attente');

            // Motif optionnel donné par l'employé
            $table->text('motif')->nullable();

            // Qui a validé/refusé la demande (RH), et quand
            $table->foreignId('valide_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('valide_le')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
