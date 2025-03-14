<?php

namespace App\Models;

use App\Models\AssignCourse;
use Illuminate\Database\Eloquent\Model;

class AssignStaffBatchProgram extends Model
{
    protected $table = 'assign_staff_batch_programs';
    protected $fillable = ['staff_id', 'course_id', 'batch_program_id', 'semester_id'];

    protected $casts = [
        'course_id' => 'array',
    ];
}
