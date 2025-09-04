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
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->decimal('customer_satisfaction_rating', 2, 1)->nullable()->after('calculated_price');
            $table->text('service_notes')->nullable()->after('customer_satisfaction_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn(['customer_satisfaction_rating', 'service_notes']);
        });
    }
};
