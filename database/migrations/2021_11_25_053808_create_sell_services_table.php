<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_services', function (Blueprint $table) {
            $table->id();
            $table->decimal('price_amount', 19, 8);
            $table->decimal('coin_amount', 19, 8);
            $table->decimal('service_charge', 19, 8);
            $table->decimal('service_charge_coin', 19, 8);
            $table->decimal('conversion_rate', 19, 8);
            $table->unsignedBigInteger('service_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->boolean('is_sale_bid');
            $table->string('coin_type', 25);
            $table->unsignedBigInteger('coin_id')->index();
            $table->tinyInteger('status');
            $table->decimal('refund_amount', 19, 8)->default(0);
            $table->unsignedBigInteger('wallet_id')->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sell_services');
    }
}
