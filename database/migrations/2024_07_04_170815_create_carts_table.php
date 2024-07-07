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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('factor_id')->constrained('users')->onDelete('cascade')->nullable();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('car_model')->constrained('cars')->onDelete('cascade')->nullable();
            $table->string('car_color')->nullable();
            $table->string('car_number')->nullable();
            $table->timestamp('car_wash')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('car_type', ['small', 'medium', 'large'])->default('small');
            $table->bigInteger('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
