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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('order_id');
            $table->string('shipping_fname');
            $table->string('shipping_lname')->nullable();
            $table->integer('shipping_country_id');
            $table->integer('shipping_city_id');
            $table->integer('shipping_zip');
            $table->string('shipping_company')->nullable();
            $table->string('shipping_email');
            $table->string('shipping_phone');
            $table->string('shipping_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
