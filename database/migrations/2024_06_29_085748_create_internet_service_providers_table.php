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
        Schema::create('internet_service_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('service_type', ['fiber', 'dsl', 'cable', 'wireless', 'satellite'])->default('fiber');
            $table->string('ip');
            $table->string('city');
            $table->string('region');
            $table->string('country');
            $table->string('loc');
            $table->string('org');
            $table->string('timezone');
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internet_service_providers');
    }
};
