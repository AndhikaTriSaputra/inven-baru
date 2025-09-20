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
        Schema::table('purchases', function (Blueprint $table) {
            // Tambah kolom category_id setelah warehouse_id
            if (!Schema::hasColumn('purchases', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('warehouse_id');

                // Relasi ke categories
                $table->foreign('category_id')
                      ->references('id')
                      ->on('categories')
                      ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            if (Schema::hasColumn('purchases', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
        });
    }
};
