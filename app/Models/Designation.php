<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = 'designations';
    protected $fillable = ['name', 'daily_rate', 'details', 'department_id', 'institution_id'];
}
