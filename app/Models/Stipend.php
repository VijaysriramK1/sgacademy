<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stipend extends Model
{
    protected $table = 'stipends';
    protected $fillable = ['student_id', 'scholarship_id', 'interval_type', 'amount', 'start_date', 'end_date', 'cycle_count', 'student_scholarship_id', 'batch_program_id'];
}
