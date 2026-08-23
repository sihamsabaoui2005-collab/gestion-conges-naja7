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
        Schema::table('users', function (Blueprint $table) {
            $table->string('fuseau_horaire')->default('Africa/Casablanca');
            $table->string('format_date')->default('d/m/Y');
            $table->boolean('notif_email')->default(true);
            $table->boolean('notif_solde')->default(true);
            $table->boolean('notif_demandes')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['fuseau_horaire', 'format_date', 'notif_email', 'notif_solde', 'notif_demandes']);
        });
    }
};