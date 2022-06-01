<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('coin_type', 20)->unique();
            $table->string('full_name', 50);
            $table->string('coin_icon', 50)->nullable();
            $table->boolean('is_currency')->default(0);
            $table->tinyInteger('deposit_status')->default(0);
            $table->tinyInteger('withdrawal_status')->default(0);
            $table->tinyInteger('active_status')->default(0);
            $table->decimal('minimum_buy_amount', 19.0, 8.0)->default(0.0000001);
            $table->decimal('minimum_sell_amount', 19.0, 8.0)->default(0.0000001);
            $table->tinyInteger('status')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('coins');
    }
}
