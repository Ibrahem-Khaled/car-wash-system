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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('role', ['admin', 'customer', 'factor'])->default('customer');
            $table->string('image')->nullable();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        }); 

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => '123456789',
            'latitude' => '35.6892',
            'longitude' => '51.3890',
            'address' => 'Tehran',
            'city' => 'Tehran',
            'status' => 'active',
            'role' => 'admin',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
