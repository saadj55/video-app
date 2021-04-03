<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAudioMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_meta', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('video_id')->index('video_id_fk');
            $table->integer('duration');
            $table->string('codec');
            $table->integer('bitrate');
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
        Schema::dropIfExists('audio_meta');
    }
}
