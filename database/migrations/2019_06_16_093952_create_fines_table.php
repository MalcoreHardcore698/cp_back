<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinesTable extends Migration
{
    public function up()
    {
        Schema::create('fines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('requisite_id');
            $table->bigInteger('fine_origin_id');
            $table->tinyInteger('paid')->default(0);
            $table->tinyInteger('showed')->default(0);
            $table->timestamps();
        });

        Schema::table('fines', function (Blueprint $table) {
            $table->foreign('requisite_id')
                ->references('id')->on('fines')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        DB::beginTransaction();

        Schema::table('fines', function (Blueprint $table) {
            $table->dropForeign('fines_requisite_id_foreign');
        });

        Schema::dropIfExists('fines');

        DB::commit();
    }
}
