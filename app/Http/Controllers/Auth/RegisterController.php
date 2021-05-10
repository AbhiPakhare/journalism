<?php

namespace App\Http\Controllers\Auth;

use App\Role;
use App\User;
use App\Phone;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'digits:10']
        ]);
    }

    /** 
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
         $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password'])
                ]);
                
         $role = new Role();
         $role->name = Role::USER;
         $user->role()->save($role);

         $phone = new Phone();
         $phone->phone_number = $data['phone'];
         $user->phone()->save($phone);

         return $user;

    }
}
