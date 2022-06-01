<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->index();
            $table->unsignedBigInteger('resell_service_id')->index()->nullable();
            $table->string('prev_mint_address')->nullable();
            $table->string('new_mint_address')->nullable();
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
        Schema::dropIfExists('transfer_tokens');
    }
}
