<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_code')->unique();
            $table->string('full_name');
            $table->string('phone', 30);
            $table->string('category', 50);
            $table->string('city', 100);
            $table->boolean('has_bnsp')->default(true);
            $table->string('status', 40)->default('SUBMITTED_FOR_REVIEW');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_registrations');
    }
};