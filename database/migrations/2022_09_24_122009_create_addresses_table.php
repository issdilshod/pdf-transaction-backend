<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type');
            $table->unsignedBigInteger('related_id');
            $table->string('address_line1')->nullable()->default('');
            $table->string('address_line2')->nullable()->default('');
            $table->unsignedBigInteger('state_id');
            $table->string('city')->nullable()->default('');
            $table->string('postal')->nullable()->default('');
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
