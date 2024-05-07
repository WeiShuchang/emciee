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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('arttype_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('stock')->default(0);
            $table->decimal('price', 8, 2)->default(0.00);
            $table->string('image')->nullable(); // Add image field
            $table->foreign('arttype_id')->references('id')->on('art_types')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
