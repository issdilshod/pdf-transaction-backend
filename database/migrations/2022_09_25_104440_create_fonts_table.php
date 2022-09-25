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
        Schema::create('fonts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('font_group_id');
            $table->string('ascii')->nullable()->default('');
            $table->string('unicode')->nullable()->default('');
            $table->string('hex')->nullable()->default('');
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('font_group_id')->references('id')->on('font_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fonts');
    }
};
