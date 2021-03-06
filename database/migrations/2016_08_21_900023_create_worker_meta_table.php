<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('worker_id')->unsigned();
            $table->string('meta_key', 45);
            $table->text('meta_value');
            $table->timestamps();

            $table->foreign('worker_id')->references('id')->on('workers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('worker_metas', function (Blueprint $table) {
            $table->dropForeign(['worker_id']);
        });

        Schema::drop('worker_metas');
    }
}
