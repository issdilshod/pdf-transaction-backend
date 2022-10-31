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
        Schema::table('statement_transactions', function (Blueprint $table) {
            $table->double('amount')->nullable()->change();
            $table->double('amount_min')->nullable()->change();
            $table->double('amount_max')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statement_transactions', function (Blueprint $table) {
            $table->double('amount')->nullable(false)->change();
            $table->double('amount_min')->nullable(false)->change();
            $table->double('amount_max')->nullable(false)->change();
        });
    }
};
