<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = [
        'title',
        'type',
        'mark',
        'error_mark',
        'status',
        'online_exam_id',
        'is_true',
        'suitable_words',
    ];

    public function online_exam()
    {
        return $this->belongsTo(OnlineExam::class, 'online_exam_id');
    }
}
