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
        Schema::create('chainsaw_requests', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number');
            $table->string('brand');
            $table->string('model');
            $table->float('bar_length');
            $table->float('engine_displacement');
            $table->date('date_acquisition');
            $table->text('description')->nullable();
            
            // User foreign key
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Status with default 'pending'
            $table->string('status')->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chainsaw_requests');
    }
};
