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
        Schema::table('shipments', function (Blueprint $table) {
            $table->date('estimated_delivery')->nullable()->after('status');
            $table->date('pickup_date')->nullable()->after('estimated_delivery');
            $table->string('pickup_time')->nullable()->after('pickup_date');
            $table->string('transit_time')->nullable()->after('pickup_time');
            $table->string('reference', 100)->nullable()->after('transit_time');
            $table->string('package_type', 100)->nullable()->after('reference');
            $table->string('weight', 50)->nullable()->after('package_type');
            $table->integer('quantity')->nullable()->after('weight');
            $table->string('service_type', 100)->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn('estimated_delivery');
            $table->dropColumn('pickup_date');
            $table->dropColumn('pickup_time');
            $table->dropColumn('transit_time');
            $table->dropColumn('reference');
            $table->dropColumn('package_type');
            $table->dropColumn('weight');
            $table->dropColumn('quantity');
            $table->dropColumn('service_type');
        });
    }
};
