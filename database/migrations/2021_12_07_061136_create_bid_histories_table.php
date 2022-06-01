<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bid_histories', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id', 25);
            $table->decimal('bid_amount', 19, 8);
            $table->decimal('coin_amount', 19, 8);
            $table->decimal('service_charge', 19, 8);
            $table->decimal('service_charge_coin', 19, 8);
            $table->decimal('conversion_rate', 19, 8);
            $table->unsignedBigInteger('service_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('coin_type', 25);
            $table->unsignedBigInteger('coin_id')->index();
            $table->tinyInteger('status');
            $table->decimal('refund_amount', 19, 8)->default(0);
            $table->unsignedBigInteger('wallet_id')->index()->nullable();
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
        Schema::dropIfExists('bid_histories');
    }
}
