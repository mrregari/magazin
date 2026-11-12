<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            // Без внешнего ключа: история заказа остаётся, даже если товар удалят
            $table->unsignedBigInteger('product_id');
            $table->string('title');
            $table->double('price');
            $table->unsignedInteger('qty');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
