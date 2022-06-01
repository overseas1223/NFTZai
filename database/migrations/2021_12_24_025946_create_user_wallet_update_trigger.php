<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWalletUpdateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::unprepared(
           'CREATE TRIGGER BALANCE_UPDATE AFTER UPDATE ON wallets FOR EACH ROW
       BEGIN
        IF (OLD.balance != NEW.balance) THEN
            INSERT INTO wallet_records  (wallet_id, previous_balance, current_balance, created_at, updated_at) VALUES (OLD.id, OLD.balance, NEW.balance, NOW(), NOW());
        END IF;
       END;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       DB::unprepared('DROP TRIGGER IF EXISTS BALANCE_UPDATE');
    }
}
