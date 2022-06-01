<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('wallet_id')->default(0)->unsigned();
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade')->onUpdate('cascade');
            $table->string('address', 255);
            $table->decimal('amount', 19, 8);
            $table->tinyInteger('address_type');
            $table->string('receiver_wallet_id')->nullable();
            $table->longText('message')->nullable();
            $table->decimal('fees', 19, 8)->default(0);
            $table->text('transaction_hash')->nullable();
            $table->tinyInteger('confirmations')->default(0);
            $table->tinyInteger('status')->default(1)->comment('status: waiting = 0, processed = 1, pending = 2, cancelled = 3');
            $table->boolean('in_queue')->default(0);
            $table->decimal('doller',19,8)->default(0);
            $table->bigInteger('withdraw_by')->unsigned();
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
        Schema::dropIfExists('withdrawals');
    }
}
