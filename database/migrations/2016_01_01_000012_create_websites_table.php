<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('websites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('url')->default(false);
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
        Schema::drop('websites');
    }
}
