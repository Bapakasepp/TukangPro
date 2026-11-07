<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('full_name');
            $table->string('phone', 30);
            $table->string('whatsapp', 30);
            $table->string('email')->nullable();
            $table->text('avatar_url')->nullable();
            $table->json('skills_category');
            $table->string('certification_level');
            $table->boolean('is_verified')->default(true);
            $table->boolean('is_online')->default(true);
            $table->decimal('distance_km', 5, 1)->default(2.0);
            $table->unsignedSmallInteger('est_arrival_minutes')->default(15);
            $table->decimal('rating_average', 3, 2)->default(4.90);
            $table->unsignedInteger('total_ratings_count')->default(100);
            $table->unsignedInteger('total_completed_jobs')->default(100);
            $table->text('bio')->nullable();
            $table->unsignedInteger('base_fee')->default(75000);
            $table->string('vehicle')->default('Honda Vario');
            $table->string('police_number', 30)->nullable();
            $table->json('skills_tags');
            $table->unsignedSmallInteger('portfolio_count')->default(15);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technicians');
    }
};