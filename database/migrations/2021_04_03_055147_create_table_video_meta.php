<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVideoMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_meta', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('video_id')->index('video_id_fk');
            $table->bigInteger('duration');
            $table->integer('height');
            $table->integer('width');
            $table->string('aspect_ratio');
            $table->integer('bitrate');
            $table->string('codec');
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
        Schema::dropIfExists('video_meta');
    }
}
