<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('broadcast_logs', function (Blueprint $table) {
            $table->id();
            $table->string('sender_name')->default('Admin NOC Jabodetabek');
            $table->text('message');
            $table->unsignedSmallInteger('target_count')->default(0);
            $table->string('priority', 20)->default('HIGH');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('broadcast_logs');
    }
};