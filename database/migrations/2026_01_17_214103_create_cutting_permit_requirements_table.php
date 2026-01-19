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
        Schema::create('cutting_permit_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cutting_permit_id')
                ->constrained('cutting_permits')
                ->onDelete('cascade');
            $table->string('file_name');
            $table->string('original_filename');
            $table->string('file_path');
            $table->string('file_type');
            $table->integer('file_size');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutting_permit_requirements');
    }
};
