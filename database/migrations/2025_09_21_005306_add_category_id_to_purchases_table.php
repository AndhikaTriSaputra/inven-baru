<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('purchases', function (Blueprint $table) {
        $table->unsignedBigInteger('category_id')->nullable()->after('provider_id');

        // Kalau pakai foreign key
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
    });
}
    /**
     * Reverse the migrations.
     */
   public function down()
{
    Schema::table('purchases', function (Blueprint $table) {
       $table->unsignedInteger('category_id')->nullable();
       $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
    });
}
};
$table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

    });
}};
