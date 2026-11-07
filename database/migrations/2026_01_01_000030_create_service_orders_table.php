<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->string('customer_name')->default('Pelanggan TukangPro');
            $table->string('customer_phone', 30)->default('+62 812-3456-7890');
            $table->string('service_address');
            $table->foreignId('service_category_id')->nullable()->constrained('service_categories')->nullOnDelete();
            $table->string('category_name');
            $table->foreignId('technician_id')->nullable()->constrained('technicians')->nullOnDelete();
            $table->string('status', 30)->default('ON_THE_WAY');
            $table->boolean('is_emergency')->default(false);
            $table->string('scheduled_arrival_at')->default('15 - 25 Menit');
            $table->text('issue_description');
            $table->json('photos_url')->nullable();
            $table->unsignedInteger('base_fee')->default(75000);
            $table->unsignedInteger('diagnostic_fee')->default(25000);
            $table->unsignedInteger('spareparts_fee')->default(0);
            $table->unsignedInteger('emergency_fee')->default(0);
            $table->unsignedInteger('total_amount')->default(100000);
            $table->string('escrow_status', 20)->default('HELD');
            $table->unsignedSmallInteger('eta_minutes')->default(15);
            $table->unsignedSmallInteger('speed_kmh')->default(32);
            $table->string('warranty_valid_until')->default('30 Hari Setelah BAST Ditandatangani');
            $table->string('ordered_label')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};