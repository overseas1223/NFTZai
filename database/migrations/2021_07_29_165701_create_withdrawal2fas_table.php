<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawal2fasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal2fas', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('wallet_id')->default(0)->unsigned();
            $table->bigInteger('coin_id')->unsigned();
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade')->onUpdate('cascade');
            $table->string('address', 255);
            $table->decimal('amount', 19, 8);
            $table->decimal('fees', 19, 8)->default(0);
            $table->text('transaction_hash')->nullable();
            $table->tinyInteger('status')->default(1)->comment('status: waiting = 0, processed = 1, pending = 2, cancelled = 3');
            $table->boolean('in_queue')->default(0);
            $table->string('ip')->default('0.0.0.0');
            $table->bigInteger('withdrawal_coin_limit_setting_id');
            $table->string('url_validation_code',100);
            $table->text('url_validation_url');
            $table->integer('verification_code')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->smallInteger('failed_count')->default(0);
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
        Schema::dropIfExists('withdrawal2fas');
    }
}
