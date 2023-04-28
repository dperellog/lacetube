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

            $table->increments('id');
            $table->string('title');
            $table->string('original_name');
            $table->string('disk');
            $table->string('path');
            $table->datetime('converted_for_downloading_at')->nullable();
            $table->datetime('converted_for_streaming_at')->nullable();
            $table->timestamps();

            //Relationships:
            $table->foreignId('activity_id')
                    ->constrained('activities', 'id')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

           $table->foreignId('user_id')
                    ->constrained('users', 'id')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
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
