<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignCatpermissionId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
          $table->unsignedBigInteger('catpermission_id')->after('id');
          $table->foreign('catpermission_id')->references('id')->on('catpermissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['catpermission_id']);
            $table->dropColumn('catpermission_id');
        });
    }
}
