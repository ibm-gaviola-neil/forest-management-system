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
        Schema::create('donation_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id');
            $table->string('blood_type');
            $table->string('date_donated');
            $table->string('expiration_date');
            $table->string('status');
            $table->integer('volume_ml');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_inventories');
    }
};
