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
        Schema::create('curs_usuari', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('curs_id'); 
            $table->foreign('curs_id')->references('id')->on('curs');

            $table->unsignedBigInteger('alumne_id'); 
            $table->foreign('alumne_id')->references('id')->on('usuaris');

            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curs_usuari');
    }
};
