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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId( 'order_id')->constrained('orders')->onDelete('cascade');
            $table->string('name',100);
            $table->float('shipping_fees');
            $table->float('discount'); // discount on shipping fees
            $table->integer('product_quantity')->nullable();
            $table->float('price')->nullable();
            $table->float('price_with_currency')->nullable();
            $table->float('price_with_quantity')->nullable();
            $table->longText('product_options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
