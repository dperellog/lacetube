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
        Schema::create('activitats', function (Blueprint $table) {
            $table->id();
            $table->date('dataFinal');
            $table->unsignedBigInteger('curs_id');
            $table->foreign('curs_id')->references('id')->on('curs');
            $table->string('titol');
            $table->text('contingut');
            $table->timestamps();
            $table->unsignedBigInteger('creatPer');
            $table->foreign('creatPer')->references('id')->on('usuaris');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activitats');
    }
};
