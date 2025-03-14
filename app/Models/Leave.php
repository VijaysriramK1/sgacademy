<?php

namespace App\Models;

use App\Helpers\UserHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $table = 'leaves';
    protected $fillable = ['staff_id', 'type_id', 'leave_type_id', 'start_date', 'end_date', 'hours_duration', 'reason', 'status', 'is_paid', 'institution_id', 'user_id', 'role_id'];


    protected static function boot()
    {
        parent::boot();
        static::created(function ($data) {
            $role = UserHelper::currentRole();

            if ($role == 'student') {
               $role_id = 2;
            } else {
               $role_id = 4;
            }

            DB::table('leaves')->where('id', $data->id)->update(['user_id' => UserHelper::currentUserDetails()->id, 'role_id' => $role_id]);
        });
    }
}
