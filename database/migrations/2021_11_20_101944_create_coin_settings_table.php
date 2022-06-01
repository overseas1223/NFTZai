<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('coin_id')->unsigned();
            $table->foreign('coin_id')->references('id')->on('coins')->onDelete('cascade')->onUpdate('cascade');
            $table->string('api_service', 50);
            $table->string('user', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('host', 255)->nullable();
            $table->integer('port')->nullable();
            $table->decimal('withdrawal_fee_percent', 19, 8)->default(0);
            $table->decimal('withdrawal_fee_fixed', 19, 8)->default(0);
            $table->tinyInteger('withdrawal_fee_method')->default(1)->comment('method: percent = 1, fixed = 2, both = 3');
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
        Schema::dropIfExists('coin_settings');
    }
}
