<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'nis',
        'password',
        'school_id',
        'role',
        'birth_date',
        'sex',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function nutritionMeasurements()
    {
        return $this->hasMany(NutritionMeasurement::class);
    }

    public function hasNutritionProfile(): bool
    {
        return $this->birth_date !== null && in_array($this->sex, ['male', 'female'], true);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'nis', // doubles as the student's password

        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }
}
