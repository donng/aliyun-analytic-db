<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSqlRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('stat_mysql')->create('sql_records', function (Blueprint $table) {
            $table->increments('id');
            $table->text('sql')->comment('sql记录');
            $table->float('time',3,3)->comment('sql执行时间(秒)');
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
        Schema::dropIfExists('sql_records');
    }
}
