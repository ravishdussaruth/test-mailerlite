<?php

use Illuminate\Support\Facades\Schema;
use App\Support\Database\Migrationable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTransactionTable extends Migration
{
    use Migrationable;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('transaction_id');
            $table->integer('from_or_to');
            $table->timestamps();
        });

        if ($this->isNotTesting()) {
            Schema::table('account_transaction', function (Blueprint $table) {
                $table->foreign('account_id')
                      ->references('id')
                      ->on('accounts');

                $table->foreign('transaction_id')
                      ->references('id')
                      ->on('transactions');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ($this->isNotTesting()) {
            Schema::table('account_transaction', function (Blueprint $table) {
                $table->dropForeign(['user_id', 'class_id']);
            });
        }

        Schema::dropIfExists('account_transaction');
    }
}
