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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('thumbnailURL');
            $table->year('year');

            $table->timestamps();

            //Relationships
            $table->foreignId('teacher_id')
                    ->nullable()
                    ->constrained('users', 'id')
                    ->onUpdate('cascade')
                    ->nullOnDelete();

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('courses', 'id')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
