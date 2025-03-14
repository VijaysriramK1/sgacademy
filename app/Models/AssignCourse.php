<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignCourse extends Model
{
    protected $table = 'assigning_courses';
    protected $fillable = ['course_id', 'staff_id', 'status', 'notes', 'assign_staff_batch_program_id'];
}
