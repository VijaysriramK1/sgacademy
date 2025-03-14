<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffRegistrationField extends Model
{
    protected $table = 'staff_registration_fields';

  
    protected $fillable = [
        'field_name',
        'label_name',
        'active_status',
        'is_required',
        'staff_edit',
        'required_type',
        'position',
        'institution_id',
    ];
}
