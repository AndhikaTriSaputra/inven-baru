<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('adjustment_details')) {
            return; // nothing to do
        }

        Schema::table('adjustment_details', function (Blueprint $table) {
            if (!Schema::hasColumn('adjustment_details', 'warehouse_id')) {
                $table->unsignedInteger('warehouse_id')->nullable()->after('adjustment_id');
                $table->index('warehouse_id');
            }
        });

        // Backfill from adjustments.warehouse_id when possible
        try {
            DB::statement(
                'UPDATE adjustment_details ad JOIN adjustments a ON a.id = ad.adjustment_id SET ad.warehouse_id = a.warehouse_id WHERE ad.warehouse_id IS NULL'
            );
        } catch (\Throwable $e) {
            // ignore if statement not supported
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('adjustment_details')) {
            return;
        }
        Schema::table('adjustment_details', function (Blueprint $table) {
            if (Schema::hasColumn('adjustment_details', 'warehouse_id')) {
                $table->dropIndex(['warehouse_id']);
                $table->dropColumn('warehouse_id');
            }
        });
    }
};


