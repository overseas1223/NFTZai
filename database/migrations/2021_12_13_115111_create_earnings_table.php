<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sell_id')->nullable();
            $table->bigInteger('bid_id')->nullable();
            $table->bigInteger('user_id')->nullable()->comment('Who debited or credited amount');
            $table->bigInteger('coin_id')->nullable();
            $table->tinyInteger('user_to_platform')->nullable();
            $table->tinyInteger('platform_to_user')->nullable();
            $table->decimal('trans_amount', 19, 8);
            $table->decimal('amount', 19, 8);
            $table->string('coin_type');
            $table->string('comments');
            $table->string('status');
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
        Schema::dropIfExists('earnings');
    }
}
