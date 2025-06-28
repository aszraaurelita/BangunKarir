<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use App\Models\InterestArea;

/**
 * @property-read Profile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection<OrganizationalExperience> $organizationalExperiences
 * @property-read \Illuminate\Database\Eloquent\Collection<Project> $projects
 * @property-read \Illuminate\Database\Eloquent\Collection<WorkExperience> $workExperiences
 * @property-read \Illuminate\Database\Eloquent\Collection<UserSkill> $skills
 * @property-read \Illuminate\Database\Eloquent\Collection<Certificate> $certificates
 * @property-read \Illuminate\Database\Eloquent\Collection<Achievement> $achievements
 * @property-read \Illuminate\Database\Eloquent\Collection<Portfolio> $portfolios
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi Tahap 1
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // Relasi Tahap 2
    public function organizationalExperiences()
    {
        return $this->hasMany(OrganizationalExperience::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function skills()
    {
        return $this->hasMany(UserSkill::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function interestAreas()
    {
        return $this->belongsToMany(InterestArea::class);
    }

    public function hasCompleteProfile()
    {
        try {
            return $this->profile && $this->profile->is_complete;
        } catch (\Exception $e) {
            Log::error('Error checking profile completion', [
                'user_id' => $this->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function getProfilePhotoAttribute()
    {
        try {
            if ($this->profile && $this->profile->photo) {
                return asset('storage/' . $this->profile->photo);
            } elseif ($this->avatar) {
                return $this->avatar;
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Error getting profile photo', [
                'user_id' => $this->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ?: asset('images/default-avatar.png');
    }

    public function isGoogleUser()
    {
        return !empty($this->google_id);
    }

    // Hitung progress profil keseluruhan
    public function getProfileCompletionPercentage()
    {
        $tahap1Weight = 60; // Tahap 1 = 60%
        $tahap2Weight = 40; // Tahap 2 = 40%

        // Progress Tahap 1
        $tahap1Progress = 0;
        if ($this->profile && $this->profile->is_complete) {
            $tahap1Progress = $this->profile->getProgressPercentage();
        }

        // Progress Tahap 2
        $tahap2Sections = [
            'organizationalExperiences' => $this->organizationalExperiences()->count() > 0,
            'projects' => $this->projects()->count() > 0,
            'workExperiences' => $this->workExperiences()->count() > 0,
            'skills' => $this->skills()->count() > 0,
            'certificates' => $this->certificates()->count() > 0,
            'achievements' => $this->achievements()->count() > 0,
            'portfolios' => $this->portfolios()->count() > 0,
        ];

        $completedSections = array_sum($tahap2Sections);
        $totalSections = count($tahap2Sections);
        $tahap2Progress = ($completedSections / $totalSections) * 100;

        // Total progress
        $totalProgress = (($tahap1Progress * $tahap1Weight) + ($tahap2Progress * $tahap2Weight)) / 100;

        return round($totalProgress);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
}
