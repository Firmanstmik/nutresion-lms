<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseType extends Model
{
    protected $fillable = ['name', 'slug', 'color'];

    public function courses()
    {
        return $this->hasMany(Course::class, 'course_type_id');
    }
}
