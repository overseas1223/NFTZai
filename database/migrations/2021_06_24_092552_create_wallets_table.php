<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('coin_id')->unsigned();
            $table->foreign('coin_id')->references('id')->on('coins')->onDelete('cascade');
            $table->string('address');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_primary')->default(0);
            $table->decimal('balance',19,8)->default(0);
            $table->decimal('on_hold',19,8)->default(0);
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
        Schema::dropIfExists('wallets');
    }
}
