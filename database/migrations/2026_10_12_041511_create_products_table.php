<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            // Внешние ключи совпадают по типу с id() (bigint unsigned)
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('status_id')->constrained();
            $table->string('img')->nullable();
            $table->double('price')->unsigned()->default(0);
            $table->double('old_price')->unsigned()->default(0);
            $table->boolean('hit')->default(false);
            $table->boolean('sale')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
