<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'thumbnail', 'school_id', 'course_type_id', 'label'];

    public function type()
    {
        return $this->belongsTo(CourseType::class, 'course_type_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order_number');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function preQuestions()
    {
        return $this->hasMany(Question::class)->where('type', 'pre');
    }

    public function postQuestions()
    {
        return $this->hasMany(Question::class)->where('type', 'post');
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
