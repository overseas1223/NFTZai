<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->decimal('bid_amount', 19, 8);
            $table->decimal('service_charge', 19, 8);
            $table->unsignedBigInteger('service_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->boolean('is_sale_bid');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('bids');
    }
}
