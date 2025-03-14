<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    protected $table = 'courses';
    protected $fillable = ['name', 'course_code', 'course_type', 'status','parent_id','institution_id'];

    public function institution(){
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function enrollments()
    {
        return $this->belongsToMany(
            Enrollment::class, 
            null, 
            'course_id', 
            'enrollment_id', 
            'id', 
            'id'
        );
    }

}
