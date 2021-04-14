<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeingMarques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marques', function (Blueprint $table) {
          $table->unsignedBigInteger('famille_id')->after('id');
          $table->foreign('famille_id')->references('id')->on('familles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('marques', function (Blueprint $table) {
          $table->dropForeign(['famille_id']);
          $table->dropColumn('famille_id');
        });
    }
}
