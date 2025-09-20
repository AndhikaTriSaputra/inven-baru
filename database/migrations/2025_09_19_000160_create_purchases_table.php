<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('Ref')->nullable();
            $table->date('date')->nullable();
            $table->foreignId('provider_id')->nullable()->constrained('providers')->nullOnDelete();
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses')->nullOnDelete();
            $table->decimal('GrandTotal', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->enum('statut', ['pending', 'received', 'cancelled'])->default('pending');
            $table->enum('payment_statut', ['unpaid', 'paid', 'partial'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};


