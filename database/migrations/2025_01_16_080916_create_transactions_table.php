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
        Schema::create('transactions',function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('amount');
            $table->enum('category',array('Transportation','Entertainment','Utilities','Food & Beverages','Health Care','Education','Investment','Others'));
            $table->enum('type',array('income','expense'));
            $table->dateTime('date');
            $table->text('description')->nullable();
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
