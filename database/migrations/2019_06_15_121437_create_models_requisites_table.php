<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsRequisitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models_requisites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('driver_id');
            $table->bigInteger('reqs_id');
            $table->timestamps();
        });

        Schema::table('models_requisites', function (Blueprint $table) {
            $table->foreign('driver_id')
                ->references('id')->on('drivers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('models_requisites', function (Blueprint $table) {
            $table->dropForeign('models_requisites_driver_id_foreign');
        });

        Schema::dropIfExists('models_requisites');
    }
}
