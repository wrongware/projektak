<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->unsigned();
            $table->integer('status_id')->unsigned()->nullable();
            $table->string('name', 45);
            $table->text('description');
            $table->text('source_int');
            $table->text('source_ext');
            $table->decimal('estimate', 5, 2);
            $table->date('deadline')->nullable();
            $table->dateTime('checked')->nullable();
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
        Schema::drop('tasks');
    }
}
