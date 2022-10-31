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
            $table->float('begining_balance')->after('period')->nullable()->default(0.00);
            $table->float('ending_balance')->after('begining_balance')->nullable()->default(0.00);
            $table->string('account_number')->after('ending_balance')->nullable()->default('');
            $table->string('item_previous_cycle')->after('account_number')->nullable()->default(0);
            $table->text('replacement')->after('item_previous_cycle')->nullable()->default('');
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
            $table->dropColumn('begining_balance');
            $table->dropColumn('ending_balance');
            $table->dropColumn('account_number');
            $table->dropColumn('item_previous_cycle');
            $table->dropColumn('replacement');
        });
    }
};
