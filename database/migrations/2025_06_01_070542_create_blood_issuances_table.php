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
        Schema::create('blood_issuances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->bigInteger('requestor_id');
            $table->bigInteger('release_by');
            $table->bigInteger('taken_by');
            $table->date('expiration_date');
            $table->date('date_of_crossmatch');
            $table->string('blood_type');
            $table->string('blood_bag_id');
            $table->string('time_of_crossmatch');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_issuances');
    }
};
