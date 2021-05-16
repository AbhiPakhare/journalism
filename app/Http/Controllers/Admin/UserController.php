<?php

namespace App\Http\Controllers\Admin;

use App\Journal;
use App\Role;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function dashboard()
    {
        $data['all_journals'] = Journal::count();
        $data['approved_journals'] = Journal::approved()->count();
        $data['waiting_journals'] = Journal::waiting()->count();
        $data['rejected_journals'] = Journal::rejected()->count();

        $data['reviewers_count'] = User::whereHas('role', function($q) {
            $q->reviewer();
        })->count();

        $data['managers_count'] = User::whereHas('role', function($q) {
            $q->reviewer();
        })->count();

        $data['users_count'] = User::whereHas('role', function($q) {
            $q->reviewer();
        })->count();

        return view('admin.home',['data',$data]);
    }
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
