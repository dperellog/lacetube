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
        Schema::create('curs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profesor_id');
            $table->foreign('profesor_id')->references('id')->on('users');
            $table->string('nom')->unique();
            $table->string('slug')->unique();
            $table->text('descripcio');
            $table->string('any');
            $table->timestamps();
            $table->unsignedBigInteger('cursPare')->nullable();
            $table->foreign('cursPare')->references('id')->on('curs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curs');
    }
};
