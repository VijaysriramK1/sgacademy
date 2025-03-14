<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineExamParticipant extends Model
{
    protected $table = 'exam_participants';

    protected $fillable = [
        'online_exam_id',
        'student_id',
        'enrollment_id',
        'mark',
        'error_mark',
        'abs',
        'status',
    ];

    /**
     * Define the relationship to the OnlineExam model.
     */
    public function onlineExam()
    {
        return $this->belongsTo(OnlineExam::class,'online_exam_id');
    }

    /**
     * Define the relationship to the Student model.
     */
    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }

    /**
     * Define the relationship to the Enrollment model.
     */
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class,'enrollment_id');
    }
}
