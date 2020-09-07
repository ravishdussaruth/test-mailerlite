<?php

use Illuminate\Support\Facades\Schema;
use \App\Support\Database\Migrationable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    use Migrationable;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->float('balance');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->float('limit_per_day')->default(1000);
            $table->string('currency')->default('usd');
            $table->timestamps();
        });

        if ($this->isNotTesting()) {
            Schema::table('accounts', function (Blueprint $table) {
                $table->foreign('client_id')
                      ->references('id')
                      ->on('oauth_clients')
                      ->onDelete('set null');
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
            Schema::table('accounts', function (Blueprint $table) {
                $table->dropForeign(['client_id']);
            });
        }

        Schema::dropIfExists('accounts');
    }
}
