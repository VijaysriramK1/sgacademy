<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRegistrationField extends Model
{
    protected $table = 'student_registration_fields';

    // Define the fillable attributes
    protected $fillable = [
        'field_name',
        'label_name',
        'is_show',
        'active_status',
        'is_required',
        'student_edit',
        'parent_edit',
        'staff_edit',
        'type',
        'is_system_required',
        'required_type',
        'position',
        'created_by',
        'updated_by',
        'institution_id',
    ];
}
