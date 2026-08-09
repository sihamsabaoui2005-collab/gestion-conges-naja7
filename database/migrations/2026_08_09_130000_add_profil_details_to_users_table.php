<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telephone')->nullable()->after('photo_path');
            $table->date('date_naissance')->nullable()->after('telephone');
            $table->string('lieu_naissance')->nullable()->after('date_naissance');
            $table->string('nationalite')->nullable()->after('lieu_naissance');
            $table->string('cin')->nullable()->after('nationalite');
            $table->string('adresse')->nullable()->after('cin');
            $table->string('situation_familiale')->nullable()->after('adresse');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telephone', 'date_naissance', 'lieu_naissance', 'nationalite', 'cin', 'adresse', 'situation_familiale']);
        });
    }
};
