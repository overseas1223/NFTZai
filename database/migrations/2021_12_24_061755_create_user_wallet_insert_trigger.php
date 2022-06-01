<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWalletInsertTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::unprepared('CREATE TRIGGER WALLET_CREATE AFTER INSERT ON wallets FOR EACH ROW
       BEGIN
            INSERT INTO wallet_records  (wallet_id, previous_balance, current_balance, created_at, updated_at) VALUES (NEW.id, NEW.balance, NEW.balance, NOW(), NOW());
        END;');
    }


    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS WALLET_CREATE');

    }
}
