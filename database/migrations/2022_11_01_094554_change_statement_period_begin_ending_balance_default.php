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
        Schema::table('statement_periods', function (Blueprint $table) {
            $table->float('begining_balance')->default(0)->change();
            $table->float('ending_balance')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statement_periods', function (Blueprint $table) {
            $table->float('begining_balance')->default(0.00)->change();
            $table->float('ending_balance')->default(0.00)->change();
        });
    }
};
