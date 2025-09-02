<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'department',
        'location',
        'type',
        'experience_level',
        'company_name',
        'company_logo',
        'company_description',
        'salary_min',
        'salary_max',
        'salary_type',
        'salary_negotiable',
        'description',
        'responsibilities',
        'requirements',
        'benefits',
        'contact_email',
        'contact_phone',
        'application_note',
        'is_active',
        'deadline'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'salary_negotiable' => 'boolean',
        'deadline' => 'date',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($jobListing) {
            if (empty($jobListing->slug)) {
                $jobListing->slug = Str::slug($jobListing->title);
            }
        });

        static::updating(function ($jobListing) {
            if ($jobListing->isDirty('title') && empty($jobListing->slug)) {
                $jobListing->slug = Str::slug($jobListing->title);
            }
        });
    }

    // Scope untuk job aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk job yang deadline-nya belum lewat
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('deadline')
                ->orWhere('deadline', '>=', now());
        });
    }

    // Scope untuk job dengan deadline mendekat (7 hari ke depan)
    public function scopeDeadlineSoon($query)
    {
        return $query->where('deadline', '>=', now())
            ->where('deadline', '<=', now()->addDays(7));
    }

    // Accessor untuk email default
    public function getContactEmailAttribute($value)
    {
        if ($value) {
            return $value;
        }

        $companySlug = Str::slug($this->company_name);
        return "hr@{$companySlug}.com";
    }

    // Accessor untuk format gaji
    public function getSalaryRangeAttribute()
    {
        if ($this->salary_min || $this->salary_max) {
            $min = $this->salary_min ? 'Rp ' . number_format($this->salary_min, 0, ',', '.') : '';
            $max = $this->salary_max ? 'Rp ' . number_format($this->salary_max, 0, ',', '.') : '';

            if ($min && $max) {
                return $min . ' - ' . $max;
            }
            return $min ?: $max;
        }
        return $this->salary_negotiable ? 'Dapat dinegosiasi' : 'Tidak disebutkan';
    }

    // Accessor untuk status deadline
    public function getDeadlineStatusAttribute()
    {
        if (!$this->deadline) {
            return null;
        }

        $daysLeft = now()->diffInDays($this->deadline, false);

        if ($daysLeft < 0) {
            return 'expired';
        } elseif ($daysLeft <= 7) {
            return 'soon';
        }

        return 'normal';
    }

    // Mutator untuk slug
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }
}