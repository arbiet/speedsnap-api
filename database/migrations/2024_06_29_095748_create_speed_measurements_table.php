<?php

// database/migrations/2024_06_29_095748_create_speed_measurements_table.php

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
        Schema::create('speed_measurements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('isp_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->float('download_speed');
            $table->float('upload_speed');
            $table->float('jitter');
            $table->float('packet_loss');
            $table->float('ping');
            $table->float('latency');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('isp_id')->references('id')->on('internet_service_providers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speed_measurements');
    }
};
