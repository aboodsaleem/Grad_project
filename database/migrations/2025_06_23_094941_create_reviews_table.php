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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // من قيّم؟ (العميل)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // المزوّد الذي استلم التقييم
            $table->foreignId('service_provider_id')->constrained('users')->onDelete('cascade');


            // الحجز المرتبط بالتقييم
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();

            // التقييم 1..5
            $table->unsignedTinyInteger('rating');

            // تعليق اختياري
            $table->text('comment')->nullable();

            $table->timestamps();

            // حجز واحد = تقييم واحد
            $table->unique(['booking_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
