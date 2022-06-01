<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->tinyInteger('type');
            $table->timestamp('expired_at');
            $table->decimal('price_dollar', 19, 8);
            $table->decimal('fees_percentage', 19, 8);
            $table->decimal('fees_fixed', 19, 8);
            $table->tinyInteger('fees_type');
            $table->integer('like')->default(0);
            $table->integer('dislike')->default(0);
            $table->decimal('available_item', 19, 8);
            $table->integer('views')->default(0);
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->tinyInteger('status');
            $table->tinyInteger('isSlider')->default(0);
            $table->string('comment')->nullable();
            $table->bigInteger('buyer_id')->unsigned()->nullable();
            $table->tinyInteger('is_resellable')->default(0);
            $table->bigInteger('resell_service_id')->unsigned()->nullable();
            $table->string('thumbnail');
            $table->string('video_link')->nullable();
            $table->string('color');
            $table->string('origin');
            $table->string('mint_address')->nullable();
            $table->decimal('max_bid_amount')->default(999999);
            $table->decimal('min_bid_amount')->default(0.01);
            $table->tinyInteger('is_unlockable')->default(0);
            $table->string('pin_date');
            $table->string('ipfsHash');
            $table->string('pinsize');
            $table->string('chain_type');
            $table->string('state')->default('waiting');
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
        Schema::dropIfExists('services');
    }
}
