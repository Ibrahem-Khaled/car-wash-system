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
        Schema::create('wallet_templates', function (Blueprint $table) {
            $table->id();
            $table->enum('platform', ['google', 'apple']);
            $table->string('pass_type_id'); // Pass Type ID من آبل أو Pass Class ID من جوجل
            $table->string('logo_text'); // النص الذي يظهر بجانب اللوجو
            $table->string('background_color'); // مثال: #6f42c1
            $table->string('foreground_color'); // مثال: #ffffff
            $table->string('label_color'); // مثال: #eeeeee
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_templates');
    }
};
