<?php

use App\Models\PushToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushTokensTable extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        Schema::create('push_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('driver_id');
            $table->text('token');
            $table->enum('platform', [PushToken::PLATFORM_ANDROID, PushToken::PLATFORM_IOS])
                ->default(PushToken::PLATFORM_ANDROID);
            $table->timestamps();
        });

        Schema::table('push_tokens', function (Blueprint $table) {
            $table->foreign('driver_id')
                ->references('id')->on('drivers')
                ->onDelete('cascade');
        });

        DB::commit();
    }

    public function down()
    {
        DB::beginTransaction();

        Schema::table('push_tokens', function (Blueprint $table) {
            $table->dropForeign('push_tokens_driver_id_foreign');
        });

        Schema::dropIfExists('push_tokens');

        DB::commit();
    }
}
