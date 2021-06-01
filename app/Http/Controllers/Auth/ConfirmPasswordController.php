<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
