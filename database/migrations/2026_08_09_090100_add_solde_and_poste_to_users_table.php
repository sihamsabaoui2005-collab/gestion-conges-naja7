<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Nombre de jours de congé accordés par an (ex: 30)
            $table->unsignedSmallInteger('solde_conges_annuel')->default(30)->after('role');

            // Poste affiché dans le tableau de bord (ex: Réceptionniste)
            $table->string('poste')->nullable()->after('solde_conges_annuel');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['solde_conges_annuel', 'poste']);
        });
    }
};
