<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConversationsTableAddSatisfiedPublicClosedFurtherTitle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('conversations', function (Blueprint $table) {
            $table->boolean('satisfied');
            $table->boolean('public');
            $table->boolean('closed');
            $table->boolean('further');
            $table->string('title');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropColumn('satisfied');
            $table->dropColumn('public');
            $table->dropColumn('closed');
            $table->dropColumn('further');
            $table->dropColumn('title');
        });
    }
}
