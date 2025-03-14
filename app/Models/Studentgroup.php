<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model
{
    protected $fillable = ['name', 'status', 'institution_id'];
    protected $table = 'student_groups';

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
