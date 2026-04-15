<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add sender & receiver contact details to shipments.
     * Run: php artisan migrate
     */
    public function up(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            // Sender extras
            $table->string('sender_email')->nullable()->after('sender_name');
            $table->string('sender_phone', 30)->nullable()->after('sender_email');
            $table->string('sender_address')->nullable()->after('sender_phone');

            // Receiver extras
            $table->string('receiver_email')->nullable()->after('receiver_name');
            $table->string('receiver_phone', 30)->nullable()->after('receiver_email');
            $table->string('receiver_address')->nullable()->after('receiver_phone');
        });
    }

    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn([
                'sender_email', 'sender_phone', 'sender_address',
                'receiver_email', 'receiver_phone', 'receiver_address',
            ]);
        });
    }
};
