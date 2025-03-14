<?php

namespace App\Models;


use App\Models\Stipend;
use Illuminate\Database\Eloquent\Model;

class StudentScholarship extends Model
{
    protected $table = 'student_scholarships';
    protected $fillable = ['program_id', 'section_id', 'group_id', 'student_id', 'scholarship_id', 'scholarship_fees_amount', 'amount', 'stipend_amount', 'awarded_date', 'batch_id', 'batch_program_id'];

    protected $casts = [
        'student_id' => 'array',
    ];
}






