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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamp('transaction_time');
            $table->decimal('total_price', 10, 2);
            $table->integer('total_quantity');
            $table->foreignId('cashier_id')->constrained('users');
            $table->enum('payment_method', ['cash', 'qris']);
            $table->integer('customer_id');
            $table->decimal('amount_payment', 10, 2);
            $table->decimal('amount_changes', 10, 2);
            $table->integer('is_sync');
            $table->string('cashier_name');
            $table->string('receipt_no');
            $table->string('status')->nullable();
            $table->string('status_payment')->nullable();
            $table->timestamp('queue_on')->nullable();
            $table->foreignId('queue_by')->nullable()->constrained('users');
            $table->timestamp('processed_on')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users');
            $table->timestamp('completed_on')->nullable();
            $table->foreignId('completed_by')->nullable()->constrained('users');
            $table->timestamp('canceled_on')->nullable();
            $table->foreignId('canceled_by')->nullable()->constrained('users');
            $table->integer('deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
