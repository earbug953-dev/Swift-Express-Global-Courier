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
        Schema::table('shipment_updates', function (Blueprint $table) {
            $table->string('status');
            $table->string('location');
            $table->text('description')->nullable();
            $table->timestamp('occurred_at');
            $table->boolean('pending')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipment_updates', function (Blueprint $table) {
            $table->dropColumn(['status', 'location', 'description', 'occurred_at', 'pending']);
        });
    }
};
