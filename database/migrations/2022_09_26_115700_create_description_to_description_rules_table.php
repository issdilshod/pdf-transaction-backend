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
        Schema::create('description_to_description_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('description_id');
            $table->unsignedBigInteger('description_rule_id');
            $table->json('value')->nullable()->default('[]');
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('description_id')->references('id')->on('descriptions');
            $table->foreign('description_rule_id')->references('id')->on('description_rules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('description_to_description_rules');
    }
};
