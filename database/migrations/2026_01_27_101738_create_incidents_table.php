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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            
            // Reporter information
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reporter_name')->nullable(); // For anonymous reports
            $table->string('reporter_email')->nullable();
            $table->string('reporter_phone')->nullable();
            $table->boolean('is_anonymous')->default(false);
            
            // Incident details
            $table->string('incident_type'); // illegal_logging, unauthorized_cutting, forest_fire, wildlife_poaching, encroachment, other
            $table->text('description');
            $table->timestamp('incident_date')->nullable(); // When the incident occurred (if known)
            
            // Location details
            $table->string('location');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('landmark')->nullable(); // Nearby landmark
            
            // Status and administration
            $table->unsignedTinyInteger('status')->default(1); // 1=new, 2=under_investigation, 3=resolved, 4=closed, 5=false_report
            $table->foreignId('assigned_to')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->text('admin_notes')->nullable();
            $table->timestamp('resolved_at')->nullable();
            
            // Evidence & attachments
            $table->boolean('has_photos')->default(false);
            $table->boolean('has_videos')->default(false);
            
            // Severity & priority
            $table->unsignedTinyInteger('severity')->default(2); // 1=low, 2=medium, 3=high, 4=critical
            $table->unsignedTinyInteger('priority')->default(2); // 1=low, 2=medium, 3=high
            
            // Related entities
            $table->foreignId('related_tree_id')->nullable()->references('id')->on('trees')->nullOnDelete();
            $table->foreignId('related_permit_id')->nullable()->references('id')->on('cutting_permits')->nullOnDelete();
            
            // Meta data
            $table->ipAddress('reported_from_ip')->nullable();
            $table->string('reported_from_device')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
