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

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('mediaURL');

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
