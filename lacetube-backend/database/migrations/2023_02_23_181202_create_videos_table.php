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
                $table->string('title');
                $table->string('description');
                $table->string('video_name');
                $table->string('streamingPath');
                $table->string('downloadPath');
                $table->string('thumbnailPath');
                $table->timestamps();

        //     //Relationships:
             $table->foreignId('activity_id')
                     ->constrained('activities', 'id')
                     ->onUpdate('cascade')
                     ->onDelete('cascade');

            $table->foreignId('user_id')
                     ->constrained('users', 'id')
                     ->onUpdate('cascade')
                     ->onDelete('cascade');
        // });
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
