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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_delivered')->default(false);
            $table->boolean('is_shipped')->default(false);
            $table->boolean('cancelled')->default(false);
            $table->string('reason_for_cancelling',50)->nullable();
            $table->string('status')->default('cart');
            $table->boolean('cancellled_notif')->default(false);
            $table->boolean('delivered_notif')->default(false);
            $table->string('fb_name',50)->nullable();
            $table->string('phone_number',50)->nullable();
            $table->integer('rating')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
