<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $table = 'admission';
    protected $fillable = [
        'admission_no',
        'student_name',
        'program',
        'father_name',
        'mother_name',
        'student_address',
        'phone_number',
        'dob',
    ];
}
