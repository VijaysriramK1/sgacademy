<?php

namespace App\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    protected $table = 'routines';

    protected $fillable = [
        'staff_id',
        'course_id',
        'lesson_id',
        'topic_id',
        'day',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'batch_program_id',
        'semester_id',
    ];

    protected $casts = [
        'topic_id' => 'array',
        'day' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }
    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }
}
