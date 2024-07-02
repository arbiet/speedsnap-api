<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coverage_areas', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('state');
            $table->foreignId('service_provider_id')->constrained('service_providers');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coverage_areas');
    }
};
