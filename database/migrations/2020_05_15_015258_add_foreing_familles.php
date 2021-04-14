<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeingFamilles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('familles', function (Blueprint $table) {
          $table->unsignedBigInteger('categorie_id')->after('id');
          $table->foreign('categorie_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('familles', function (Blueprint $table) {
          $table->dropForeign(['categorie_id']);
          $table->dropColumn('categorie_id');
        });
    }
}
