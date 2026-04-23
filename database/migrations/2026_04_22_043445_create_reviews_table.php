<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // relasi ke attraction
            $table->foreignId('attraction_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('reviewer');
            $table->text('description');
            $table->integer('rating');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};