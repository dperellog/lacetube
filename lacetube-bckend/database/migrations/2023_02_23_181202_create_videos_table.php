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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creatPer');
            $table->foreign('creatPer')->references('id')->on('usuaris');
            $table->unsignedBigInteger('activitat_id');
            $table->foreign('activitat_id')->references('id')->on('activitats');
            $table->string('titol');
            $table->string('descripcio');
            $table->timestamps();
            $table->string('media');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
