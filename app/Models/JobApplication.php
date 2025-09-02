<?php
// app/Models/JobApplication.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_listing_id',
        'name',
        'email',
        'phone',
        'address',
        'date_of_birth',
        'resume_path',
        'cover_letter',
        'status',
        'applied_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'applied_at' => 'datetime',
    ];

    // Relationship dengan JobListing
    public function jobListing()
    {
        return $this->belongsTo(JobListing::class);
    }

    // Accessor untuk mendapatkan URL resume
    public function getResumeUrlAttribute()
    {
        return $this->resume_path ? asset('storage/' . $this->resume_path) : null;
    }
}