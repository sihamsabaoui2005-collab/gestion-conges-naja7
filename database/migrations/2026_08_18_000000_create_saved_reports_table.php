<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saved_reports', function (Blueprint $table) {
            $table->string('modele_rapport')->default('standard')->after('format');
        });
    }

    public function down(): void
    {
        Schema::table('saved_reports', function (Blueprint $table) {
            $table->dropColumn('modele_rapport');
        });
    }
};