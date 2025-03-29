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
        Schema::create('donation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('donor_id')->constrained()->cascadeOnDelete();
            $table->integer('staff_id');
            $table->integer('volume_ml');
            $table->integer('qnty');
            $table->string('blood_bag_id');
            $table->string('date_process');
            $table->string('province');
            $table->string('city');
            $table->string('barangay');
            $table->string('donation_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_histories');
    }
};
