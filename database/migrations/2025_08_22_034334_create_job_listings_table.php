<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            // Tambah kolom yang hilang
            $table->string('experience_level')->nullable()->after('type');
            $table->date('deadline')->nullable()->after('is_active');
            
            // Salary information
            $table->decimal('salary_min', 15, 2)->nullable()->after('company_logo');
            $table->decimal('salary_max', 15, 2)->nullable()->after('salary_min');
            $table->enum('salary_type', ['monthly', 'yearly', 'hourly', 'project'])->default('monthly')->after('salary_max');
            $table->boolean('salary_negotiable')->default(false)->after('salary_type');
            
            // Company and contact information
            $table->longText('company_description')->nullable()->after('company_logo');
            $table->string('contact_phone')->nullable()->after('contact_email');
            
            // Update type enum untuk menambah Freelance
            $table->enum('type', ['Full-time', 'Part-time', 'Contract', 'Internship', 'Freelance'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropColumn([
                'experience_level',
                'deadline',
                'salary_min',
                'salary_max',
                'salary_type',
                'salary_negotiable',
                'company_description',
                'contact_phone'
            ]);
            
            // Revert type enum
            $table->enum('type', ['Full-time', 'Part-time', 'Contract', 'Internship'])->change();
        });
    }
};