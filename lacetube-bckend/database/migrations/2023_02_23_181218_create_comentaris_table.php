<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comentaris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creatPer');
            $table->foreign('creatPer')->references('id')->on('usuaris');
            $table->integer('valoracio');
            $table->text('descripcio')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('video_id');
            $table->foreign('video_id')->references('id')->on('videos');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentaris');
    }
};
