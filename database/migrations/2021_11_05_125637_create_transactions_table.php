<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 19, 8);
            $table->unsignedBigInteger('buyer_id')->index();
            $table->unsignedBigInteger('seller_id')->index();
            $table->string('transaction_hash');
            $table->unsignedBigInteger('bid_id')->index()->nullable();
            $table->decimal('fees', 19, 8);
            $table->timestamp('transaction_time');
            $table->tinyInteger('status');
            $table->string('coin_type', 25);
            $table->unsignedBigInteger('coin_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
