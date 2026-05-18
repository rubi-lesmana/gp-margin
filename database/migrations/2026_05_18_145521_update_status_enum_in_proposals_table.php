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
        DB::statement("
            ALTER TABLE sales_proposals
            MODIFY COLUMN status ENUM(
                'approved',
                'pending_approval',
                'manager_approved',
                'rejected'
            ) NOT NULL DEFAULT 'pending_approval'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE sales_proposals
            MODIFY COLUMN status ENUM(
                'approved',
                'pending_approval',
                'rejected'
            ) NOT NULL DEFAULT 'pending_approval'
        ");
    }
};