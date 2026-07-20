<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultAnswer extends Model
{
    protected $fillable = [
        'result_id',
        'question_id',
        'selected_answer',
        'is_correct',
        'points',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'points' => 'integer',
    ];

    public function result()
    {
        return $this->belongsTo(Result::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
