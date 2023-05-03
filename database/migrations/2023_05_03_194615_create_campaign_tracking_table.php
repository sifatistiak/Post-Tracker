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
        Schema::create('campaign_tracking', function (Blueprint $table) {
            $table->date('date');
            $table->char('country_code', 2); //assuming 2 Digit ISO
            // using 'unsignedBigInteger' assuming that those are fk
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('creative_id');
            $table->unsignedTinyInteger('browser_id');
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('count');

            $table->primary([
                'date',
                'country_code',
                'campaign_id',
                'creative_id',
                'browser_id',
                'device_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_tracking');
    }
};
