<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('purchases') && !Schema::hasColumn('purchases','image')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->string('image', 191)->nullable()->after('notes');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('purchases') && Schema::hasColumn('purchases','image')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }
    }
};
