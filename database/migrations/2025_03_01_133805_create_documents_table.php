<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('documents', function (Blueprint $table) {
            $table->id('document_id'); 
            $table->unsignedBigInteger('idea_id'); 
            $table->string('file_path');
            $table->timestamps();


            $table->foreign('idea_id')->references('idea_id')->on('ideas')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('documents');
    }
};

