<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('category_name');
            $table->string('title');
            $table->text('description');
            $table->unsignedInteger('base_price');
            $table->unsignedSmallInteger('estimated_duration_minutes')->default(60);
            $table->string('icon')->default('build');
            $table->text('image_url')->nullable();
            $table->unsignedSmallInteger('active_tech_count')->default(10);
            $table->string('tag_color', 20)->default('primary');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_categories');
    }
};