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
        Schema::create('notification_models', function (Blueprint $table) {
            $table->id();

            // Ensure user_id and factor_id are unsignedBigInteger and match the referenced tables
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('factor_id')->nullable()->constrained('users')->onDelete('set null');

            // Notification details
            $table->string('title');
            $table->text('description');  // Use text if descriptions can be long
            $table->string('image')->nullable();  // Image can be null if not always required
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_models');
    }
};
