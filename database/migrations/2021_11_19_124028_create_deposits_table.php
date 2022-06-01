<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('receiver_wallet_id')->default(0)->unsigned();
            $table->foreign('receiver_wallet_id')->references('id')->on('wallets')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('amount', 19, 8);
            $table->string('address');
            $table->decimal('fees',19,8)->default(0);
            $table->bigInteger('sender_wallet_id')->nullable();
            $table->tinyInteger('address_type')->default(1);
            $table->string('type')->nullable();
            $table->decimal('doller',19,8)->default(0);
            $table->string('transaction_id');
            $table->integer('confirmations')->default(0);
            $table->string('transaction_hash', 191)->nullable();
            $table->tinyInteger('status')->default(1)->comment('status: waiting = 0, processed = 1, pending = 2, cancelled = 3');
            $table->unique(['receiver_wallet_id', 'transaction_hash']);
            $table->bigInteger('deposit_by')->unsigned();
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
        Schema::dropIfExists('deposits');
    }
}
