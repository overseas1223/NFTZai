<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalCoinLimitSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_coin_limit_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('from',19,8);
            $table->decimal('to',19,8);
            $table->tinyInteger('id_verify_status')->default(0);
            $table->boolean('phone_verify_status')->default(true);
            $table->boolean('admin_approval')->default(false);
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('google2fa')->default(0);
            $table->boolean('email2fa')->default(0);
            $table->bigInteger('coin_id');
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
        Schema::dropIfExists('withdrawal_coin_limit_settings');
    }
}
