<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE leave_requests MODIFY COLUMN type ENUM('paye', 'maladie', 'sans_solde', 'exceptionnel', 'rtt', 'autre') NOT NULL DEFAULT 'paye'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE leave_requests MODIFY COLUMN type ENUM('paye', 'maladie', 'sans_solde') NOT NULL DEFAULT 'paye'");
    }
};