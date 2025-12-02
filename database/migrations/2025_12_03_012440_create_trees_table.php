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
        Schema::create('trees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Assuming each tree is associated with a user.
            $table->string('treeId');           // Assuming it's a string. Use ->integer() if it's a number.
            $table->string('treeType');
            $table->date('datePlanted');
            $table->float('height');            // You can use decimal if you want more precision.
            $table->float('diameter');          // Same here.
            $table->string('location');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trees');
    }
};
