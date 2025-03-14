<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $table = 'homeworks';
    protected $fillable = ['homework_date', 'submission_date', 'evaluation_date', 'file', 'marks', 'description', 'status', 'evaluated_by','program_id','course_id','section_id'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    

    public function evaluatedBy()
    {
        return $this->belongsTo(Enrollment::class, 'evaluated_by');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class);
    }
}
