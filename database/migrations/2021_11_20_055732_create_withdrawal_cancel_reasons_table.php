<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalCancelReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_cancel_reasons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('withdrawal_id')->unsigned();
            $table->foreign('withdrawal_id')->references('id')->on('withdrawals')->onDelete('cascade')->onUpdate('cascade');
            $table->text('reason')->nullable();
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
        Schema::dropIfExists('withdrawal_cancel_reasons');
    }
}
