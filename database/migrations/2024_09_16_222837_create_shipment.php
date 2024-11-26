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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();
            $table->date('start_date',);
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'finished', 'pending', 'delivered'])->default('pending');
            $table->integer('order_count')->default(0);
            $table->integer('product_count')->default(0);
            $table->integer('currency_price')->default(0);
            $table->integer('customer_currency_price')->default(0);
            $table->integer('shipping_fees_total_profit')->default(0);
            $table->integer('currency_profit')->default(0);
            $table->integer('total_profit')->default(0);
            $table->integer('total_price')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
