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
        Schema::create('articles', function (Blueprint $table) {
            $table->id(); // crea una colonna di nome id, bigint unsigned, primary key, auto_increment
            $table->string('title', 150); // crea una colonna di nome "title" di tipo varchar(150)
            // $table->string('title'); // crea una colonna di nome "title" di tipo varchar(255)
            $table->string('category', 50);
            $table->text('body')->nullable();
            $table->boolean('visible')->default(true); // boolean è alias per tinyint(1)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
