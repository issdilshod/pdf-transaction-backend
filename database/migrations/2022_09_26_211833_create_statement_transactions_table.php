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
        Schema::create('statement_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('period_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->dateTime('date');
            $table->float('amount')->default(0.00);
            $table->float('amount_min')->default(0.00);
            $table->float('amount_max')->default(0.00);
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('period_id')->references('id')->on('statement_periods');
            $table->foreign('type_id')->references('id')->on('transaction_types');
            $table->foreign('category_id')->references('id')->on('transaction_categories');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('sender_id')->references('id')->on('senders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statement_transactions');
    }
};
