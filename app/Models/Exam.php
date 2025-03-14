<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';
    protected $fillable = [
        'exam_type_id',
        'total_mark',
        'pass_mark',
        'date',
        'start_time',
        'end_time',
        'staff_id',
        'status',
        'program_id',
        'semester_id',
        'course_id',
        'section_id',
        'batch_id',
        'institution_id',
        'created_by',
        'updated_by',
    ];

    public function examtype(){
        return $this->belongsTo(ExamType::class,'exam_type_id');
    }

    public function prograss(){
        return $this->belongsTo(Program::class,'program_id');
    }

    public function staff(){
        return $this->belongsTo(Staff::class,'staff_id');
    }

    public function semester(){
        return $this->belongsTo(Semester::class,'semester_id');
    }
    public function Course(){
        return $this->belongsTo(Courses::class,'course_id');
    }
    public function section(){
        return $this->belongsTo(Section::class,'section_id');
    }
    public function batch(){
        return $this->belongsTo(Batch::class,'batch_id');
    }


}
