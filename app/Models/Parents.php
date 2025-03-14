<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Parents extends Authenticatable
{
    use Notifiable;
    protected $table = 'parents';
    protected $fillable = ['first_name', 'last_name', 'email', 'mobile', 'gender', 'blood_group', 'user_id', 'institution_id'];
}
