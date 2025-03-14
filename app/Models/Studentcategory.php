<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCategory extends Model
{
    protected $fillable = ['name', 'status', 'institution_id'];

    protected $table = 'student_categories';

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
