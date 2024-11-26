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
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('role', ['admin', 'customer', 'factor', 'company','supervisor'])->default('customer');
            $table->string('image')->nullable()->default('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse1.mm.bing.net%2Fth%3Fid%3DOIP.jQvFuRlmVesA7K6ArjfyrAHaH9%26pid%3DApi%26h%3D160&f=1&ipt=cf445510efbffaae5e0ba584d6e07fd887ed3424659c89452cd311e407bb287d&ipo=images');
            $table->string('password');
            $table->float('points')->nullable()->default(0.00);
            $table->string('expo_push_token')->unique()->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            [
                [
                    'name' => 'admin',
                    'email' => 'admin@admin.com',
                    'phone' => '554312152',
                    'address' => 'Tehran',
                    'city' => 'Tehran',
                    'status' => 'active',
                    'role' => 'admin',
                    'password' => bcrypt('12345678'),
                    'email_verified_at' => now(),
                ],
                [
                    'name' => 'المركبة المخملية',
                    'email' => 'company@company.com',
                    'phone' => '1111111111',
                    'address' => 'saudi arabia',
                    'city' => 'saudi arabia city',
                    'status' => 'active',
                    'role' => 'company',
                    'password' => bcrypt('12345678'),
                    'email_verified_at' => now(),
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
