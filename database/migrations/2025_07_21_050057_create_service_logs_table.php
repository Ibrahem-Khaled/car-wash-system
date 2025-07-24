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
        Schema::create('service_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade'); // العميل
            $table->foreignId('scanned_by_user_id')->constrained('users')->onDelete('cascade'); // من قام بالمسح
            $table->boolean('is_reward')->default(false); // هل هذه الخدمة كانت هدية؟
            $table->string('gifted_to_phone_number')->nullable(); // الرقم الذي تم إهداء الخدمة له
            $table->boolean('is_used')->default(false)->after('is_reward');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_logs');
    }
};
