<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProviderAliasesTable extends Migration
{
    public function up()
    {
        Schema::create('service_provider_aliases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_provider_id');
            $table->string('alias_name');
            $table->string('alias_org')->nullable();
            $table->timestamps();

            $table->foreign('service_provider_id')->references('id')->on('service_providers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_provider_aliases');
    }
}
