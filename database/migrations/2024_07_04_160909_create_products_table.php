<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('type', ['main', 'sub'])->default('main');
            $table->decimal('small_car_price', 8, 2)->nullable();
            $table->decimal('medium_car_price', 8, 2)->nullable();
            $table->decimal('large_car_price', 8, 2)->nullable();
            $table->decimal('x_large_car_price', 8, 2)->nullable();
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
