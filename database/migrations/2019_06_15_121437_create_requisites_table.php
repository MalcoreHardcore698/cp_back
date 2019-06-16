<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisitesTable extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        Schema::create('requisites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('driver_id');
            $table->bigInteger('reqs_id');
            $table->timestamps();
        });

        Schema::table('requisites', function (Blueprint $table) {
            $table->foreign('driver_id')
                ->references('id')->on('drivers')
                ->onDelete('cascade');
        });

        DB::commit();
    }

    public function down()
    {
        DB::beginTransaction();

        Schema::table('requisites', function (Blueprint $table) {
            $table->dropForeign('requisites_driver_id_foreign');
        });

        Schema::dropIfExists('requisites');

        DB::commit();
    }
}
