<?php
// database/migrations/xxxx_create_job_applications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_listing_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->date('date_of_birth');
            $table->string('resume_path');
            $table->text('cover_letter')->nullable();
            $table->enum('status', ['pending', 'reviewing', 'interview', 'accepted', 'rejected'])->default('pending');
            $table->timestamp('applied_at');
            $table->timestamps();

            // Indexes
            $table->index(['job_listing_id', 'status']);
            $table->index('email');
            $table->index('applied_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};