<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function listOfUsers()
    {
        $users = User::withCount('journal')
        ->with(['phone'])
        ->whereHas('role', function ($query) {
            $query->where('name', Role::USER);
        })
        ->latest()
        ->paginate(5);

        
        return view('admin.listOfUsers', compact('users'));
    }
}
