<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwoFactorSetting extends Model
{
    protected $table = 'two_factor_settings'; 
    protected $fillable = [
        'via_sms',
        'via_email',
        'for_student',
        'for_parent',
        'for_teacher',
        'for_staff',
        'for_admin',
        'expired_time',
        'institution_id'
    ];

}
