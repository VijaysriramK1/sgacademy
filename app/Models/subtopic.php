<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtopic extends Model
{
    protected $table = 'sub_topics';
    protected $fillable = [
        'lesson_id', 'title', 'content', 'max_marks', 'avg_marks', 'image', 'program_id', 'section_id', 'course_id', 'topic_id'
    ];

   
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

 
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
