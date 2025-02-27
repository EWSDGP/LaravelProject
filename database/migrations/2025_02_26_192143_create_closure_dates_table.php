<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('closure_dates', function (Blueprint $table) {
            $table->id('ClosureDate_id');
            $table->date('Idea_ClosureDate');
            $table->date('Comment_ClosureDate');
            $table->string('Academic_Year');
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('closure_dates');
    }
};
