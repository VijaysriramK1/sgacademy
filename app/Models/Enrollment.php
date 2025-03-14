<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Enrollment extends Model
{
    protected $table = 'enrollments';
    
    protected $fillable = [
        'student_id', 
        'batch_program_id', 
        'section_id', 
        'roll_no', 
        'is_promote', 
        'is_graduate', 
        'is_default', 
        'enrolled_at', 
        'course_ids', 
        'badge_id', 
        'student_category_id', 
        'student_group_id'
    ];

    protected $casts = [
        'course_ids' => 'array',
        'enrolled_at' => 'date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function batchProgram()
    {
        return $this->belongsTo(BatchPrograms::class, 'batch_program_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function studentCategory()
    {
        return $this->belongsTo(StudentCategory::class);
    }

    public function studentGroup()
    {
        return $this->belongsTo(StudentGroup::class);
    }

   
    public function courses()
    {
        return $this->belongsTo(Courses::class,'course_ids');
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'badge_id');
    }

   
    public function getCoursesNamesAttribute()
    {
        if (!$this->course_ids) {
            return [];
        }

        return Courses::whereIn('id', $this->course_ids)
            ->pluck('name')
            ->toArray();
    }

   
}