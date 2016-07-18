<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function($table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('expert_id')->unsigned();
            $table->string('doctors');
            $table->integer('conv_id')->unsigned();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('age')->nullable();
            $table->string('town')->nullable();
            $table->string('symptom')->nullable();
            $table->string('info')->nullable();
            $table->string('health_record')->nullable();
            $table->boolean('has_consultation')->nullable();
            $table->integer('choose')->nullable();
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
        Schema::drop('forms');
    }
}
