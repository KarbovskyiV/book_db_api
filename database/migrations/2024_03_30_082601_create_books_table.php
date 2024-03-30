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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('authors');
            $table->string('title');
            $table->string('genre');
            $table->text('description')->nullable();
            $table->string('edition')->nullable();
            $table->string('publisher')->nullable();
            $table->date('year')->nullable();
            $table->string('format')->nullable()->comment('Type of book cover');
            $table->string('pages')->nullable();
            $table->string('country')->nullable();
            $table->string('ISBN')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
