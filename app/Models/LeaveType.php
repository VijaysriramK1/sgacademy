<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $table = 'leave_types';
    protected $fillable = ['name', 'days', 'is_active', 'institution_id'];
}
