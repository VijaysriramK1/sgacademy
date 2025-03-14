<?php

namespace App\Helpers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserHelper
{

public static function currentRole()
{
   $guards = ['student', 'parent', 'staff'];
     foreach ($guards as $value) {
        if (Auth::guard($value)->check()) {
              $guard = $value;
        }
     }
    return $guard;
}

public static function currentRoleDetails()
{
    $guards = ['student', 'parent', 'staff'];
      foreach ($guards as $value) {
        if (Auth::guard($value)->check()) {
              $guard = $value;
        }
      }
        if ($guard == 'student') {
            $role_details = Auth::guard('student')->user();
        } else if ($guard == 'parent') {
            $role_details = Auth::guard('parent')->user();
        } else if ($guard == 'staff') {
            $role_details = Auth::guard('staff')->user();
        } else {
            $role_details = 'null';
        }

        return $role_details;
}

public static function currentUserDetails()
{
    $guards = ['student', 'parent', 'staff'];
      foreach ($guards as $value) {
        if (Auth::guard($value)->check()) {
              $guard = $value;
        }
      }
        if ($guard == 'student' || $guard == 'parent' || $guard == 'staff') {
            $user_details = Auth::guard('web')->user();
        } else {
            $user_details = 'null';
        }

    return $user_details;
}

public static function currentRolePermissionDetails()
{
    $guards = ['student', 'parent', 'staff'];
    foreach ($guards as $value) {
      if (Auth::guard($value)->check()) {
            $guard = $value;
      }
    }

    if ($guard == 'student') {
        $role_id = 2;
    } else if ($guard == 'parent') {
        $role_id = 3;
    } else if ($guard == 'staff') {
        $role_id = 4;
    } else {
        $role_id = 0;
    }

    if ($role_id != 0) {
        $role_permissions = DB::table('role_has_permissions')->where('role_id', $role_id)->get();

        if ($role_permissions->isEmpty()) {
            $get_permissions = [];
        } else {
            $get_permissions = Permission::whereIn('id', $role_permissions->pluck('permission_id'))->pluck('name')->toArray();
        }
    } else {
        $get_permissions = [];
    }

    return $get_permissions;
}

}

