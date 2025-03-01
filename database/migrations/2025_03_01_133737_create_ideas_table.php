<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('ideas', function (Blueprint $table) {
            $table->id('idea_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('category_id'); 
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->unsignedBigInteger('closure_date_id'); 
            $table->timestamps();

          
            $table->foreign('closure_date_id')->references('ClosureDate_id')->on('closure_dates')->onDelete('cascade');
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('ideas');
    }
};

