<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationWebsitesOrganizations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('websites', function ($table) {
            $table->integer('organization_id')->unsigned()->nullable()->index();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('websites', function ($table) {
            $table->dropForeign('websites_organization_id_foreign');
            $table->dropColumn('organization_id');
        });
    }
}
