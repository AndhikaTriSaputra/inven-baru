<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            if (!Schema::hasColumn('brands', 'image')) {
                $table->string('image')->nullable()->after('name');
            }
            if (!Schema::hasColumn('brands', 'description')) {
                $table->text('description')->nullable()->after('image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            if (Schema::hasColumn('brands', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('brands', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};


