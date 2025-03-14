<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    protected $table = 'course_sections';
    protected $fillable = ['course_id', 'section_id', 'batch_id', 'status', 'institution_id', 'batch_program_id', 'courses', 'semester_id'];

    protected $casts = [
        'courses' => 'array'
    ];

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
}
