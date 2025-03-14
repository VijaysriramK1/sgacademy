<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    protected $table = 'student_attendances';
    protected $fillable = ['student_id', 'date', 'status', 'course_id', 'batch_program_id', 'semester_id'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
