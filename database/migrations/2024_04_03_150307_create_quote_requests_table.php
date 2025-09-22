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
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('fence_type')->nullable();
            $table->string('product_name')->nullable();
            $table->longText('design_options')->nullable();
            $table->string('size_of_area')->nullable();
            $table->string('will_you_need_pavers')->nullable();
            $table->string('will_you_need_a_screen_pergola_or_pavilion')->nullable();
            $table->longText('what_will_this_area_be_used_for')->nullable();
            $table->longText('features')->nullable();
            $table->string('style_options')->nullable();
            $table->string('how_many_gates')->nullable();
            $table->longText('additional_comments')->nullable();
            $table->longText('appliances')->nullable();
            $table->string('counter_top')->nullable();
            $table->string('phone')->nullable();
            $table->string('paver_type')->nullable();
            $table->string('color_options')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('email');
            $table->string('address_line_one');
            $table->string('address_line_two')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
