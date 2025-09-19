<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'type_barcode')) {
                $table->string('type_barcode')->nullable()->after('code');
            }
            if (!Schema::hasColumn('products', 'stock_alert')) {
                $table->integer('stock_alert')->default(0)->after('image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'type_barcode')) {
                $table->dropColumn('type_barcode');
            }
            if (Schema::hasColumn('products', 'stock_alert')) {
                $table->dropColumn('stock_alert');
            }
        });
    }
};


