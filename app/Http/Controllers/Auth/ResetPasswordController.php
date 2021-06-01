<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Role;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    public function redirectTo() {
        $role = auth()->user()->role->name;

        switch ($role) {
            case Role::ADMIN:
                return '/admin/dashboard';
                break;
            case Role::MANAGER:
                return '/manager/dashboard';
                break;
            case Role::REVIEWER:
                return '/reviewer/dashboard';
                break;
            case Role::USER:
                return '/user/dashboard';
                break;
            default:
                return '/home';
                break;
        }
    }
}
