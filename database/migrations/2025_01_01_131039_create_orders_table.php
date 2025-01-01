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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('user_name');
            $table->string('user_phone');
            $table->string('user_email');

            $table->decimal('price', 8, 2);
            $table->decimal('shapping_price', 8, 2);
            $table->decimal('total_price', 8, 2);

            $table->text('note');
            $table->enum('status' , ['pending','completed','cancelled' , 'delivered'])->default('pending');

            $table->string('country');
            $table->string('governorate');
            $table->string('city');
            $table->string('street');

            $table->timestamps();
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
