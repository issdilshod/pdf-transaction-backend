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
        Schema::create('statement_periods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('statement_id');
            $table->date('period');
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('statement_id')->references('id')->on('statements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statement_periods');
    }
};
