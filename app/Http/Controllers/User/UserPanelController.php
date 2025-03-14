<?php

namespace App\Http\Controllers\User;

use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserPanelController extends Controller
{
    public function userLogout(Request $request)
    {
        $role = UserHelper::currentRole();
        Auth::guard($role)->logout();
        session()->forget($role);
        Auth::guard('web')->logout();
        session()->forget('web');
        return redirect('/login');
    }
}
