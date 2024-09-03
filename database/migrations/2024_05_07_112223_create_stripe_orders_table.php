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
        Schema::create('stripe_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('total');
            $table->integer('discount');
            $table->integer('charge');
            $table->string('fname');
            $table->string('lname')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->integer('zip');
            $table->integer('country_id');
            $table->integer('city_id');
            $table->string('company')->nullable();
            $table->string('notes')->nullable();
            $table->string('shipping_fname')->nullable();
            $table->string('shipping_lname')->nullable();
            $table->integer('shipping_country_id')->nullable();
            $table->integer('shipping_city_id')->nullable();
            $table->integer('shipping_zip')->nullable();
            $table->string('shipping_company')->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_address')->nullable();
            $table->integer('ship_check')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_orders');
    }
};
