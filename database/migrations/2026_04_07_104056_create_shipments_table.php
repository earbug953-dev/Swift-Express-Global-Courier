<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('shipments', function (Blueprint $table) {
        $table->id();
        $table->string('tracking_number')->unique();
        $table->string('sender_name');
        $table->string('receiver_name');
        $table->string('origin');
        $table->string('destination');
        $table->string('status')->default('In Transit');

        // YOU control this
        $table->integer('progress')->default(10);

        // Product image
        $table->string('product_image')->nullable();

        // Map movement
        $table->string('current_lat')->default('39.8561'); // Example starting point
        $table->string('current_lng')->default('-104.6737');

        // Auto movement toggle
        $table->boolean('map_moving')->default(true);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
