<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_details', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name');
            $table->decimal('price', 10, 2);
            $table->integer('download_speed'); // Bandwidth Download (Mbps)
            $table->integer('upload_speed'); // Bandwidth Upload (Mbps)
            $table->integer('FUP'); // Fair Usage Policy (GB)
            $table->integer('free_extra_quota'); // Free Extra Quota (GB)
            $table->integer('downgrade_speed'); // Downgrade Speed (Mbps)
            $table->integer('devices'); // Number of Devices Supported
            $table->boolean('IP_dynamic'); // IP Dynamic (true/false)
            $table->boolean('IP_public'); // IP Dynamic (true/false)
            $table->boolean('modem'); // Modem provided (true/false)
            $table->foreignId('service_provider_id')->constrained('service_providers');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_details');
    }
};
