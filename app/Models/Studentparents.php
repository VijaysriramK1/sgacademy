<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studentparents extends Model
{
    protected $table = 'student_parents';
    protected $fillable = [
        'student_id',
        'parent_id',
        'relation',
        'created_by',
        'updated_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function parent()
    {
        return $this->belongsTo(StudentParent::class, 'parent_id');
    }
}
