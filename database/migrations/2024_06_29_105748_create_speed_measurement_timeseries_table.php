<?php

// database/migrations/2024_06_29_105748_create_speed_measurement_timeseries_table.php

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
        Schema::create('speed_measurement_timeseries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('speed_measurement_id');
            $table->timestamp('timestamp');
            $table->float('download_speed');
            $table->float('upload_speed');
            $table->float('jitter');
            $table->float('packet_loss');
            $table->float('ping');
            $table->float('latency');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('speed_measurement_id')->references('id')->on('speed_measurements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speed_measurement_timeseries');
    }
};
