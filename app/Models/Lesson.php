<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    public const DEFAULT_DURATION_MINUTES = 2;

    protected $fillable = ['course_id', 'title', 'content', 'video_url', 'order_number', 'duration_minutes'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function studyDurationMinutes(): int
    {
        return max(1, (int) ($this->duration_minutes ?? self::DEFAULT_DURATION_MINUTES));
    }

    public function studyDurationSeconds(): int
    {
        return $this->studyDurationMinutes() * 60;
    }

    public function studyDurationLabel(): string
    {
        $minutes = $this->studyDurationMinutes();

        return sprintf('%d:%02d Menit', $minutes, 0);
    }
}
