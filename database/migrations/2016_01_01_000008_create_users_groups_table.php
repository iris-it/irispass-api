<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('users_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('realname');
            $table->text('path');
            $table->uuid('organization_uuid');
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
        Schema::drop('users_groups');
    }
}
