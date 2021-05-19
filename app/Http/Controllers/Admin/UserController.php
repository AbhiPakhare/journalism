<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use App\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;

class UserController extends Controller
{
    public function dashboard()
    {
        $data['all_journals'] = Journal::count();
        $data['approved_journals'] = Journal::approved()->count();
        $data['waiting_journals'] = Journal::waiting()->count();
        $data['rejected_journals'] = Journal::rejected()->count();
		$data['all_users'] = User::count();
        $data['reviewers_count'] = User::whereHas('role', function($q) {
            $q->reviewer();
        })->count();

        $data['managers_count'] = User::whereHas('role', function($q) {
            $q->manager();
        })->count();

        $data['users_count'] = User::whereHas('role', function($q) {
            $q->user();
        })->count();

        return view('admin.home',['data' => $data]);
    }
	
	public function jouranlWaiting()
	{	
		$journals = cache()->remember('journal-waiting-api', 60 * 5, function(){
			return Journal::whereBetween('created_at', [now()->subDays(30), now()])
				   ->where('status', 'Waiting')
				   ->orderBy('created_at')->get()->groupBy(function($journal) {
					   return $journal->created_at->format('d-M');
				   });
		});

		$data = [];
		foreach($journals as $date => $journal) {
			$data[$date] = $journal->count();
		}

		return response()->json($data);
	}
	public function jouranlApproved()
	{	
		$journals = cache()->remember('journal-approved-api', 60 * 5, function(){
			return Journal::whereBetween('created_at', [now()->subDays(30), now()])
				   ->where('status', 'Approved')
				   ->orderBy('created_at')->get()->groupBy(function($journal) {
					   return $journal->created_at->format('d-M');
				   });
		});

		$data = [];
		foreach($journals as $date => $journal) {
			$data[$date] = $journal->count();
		}

		return response()->json($data);
	}
	public function jouranlRejected()
	{	
		$journals = cache()->remember('journal-rejected-api', 60 * 5, function(){
			return Journal::whereBetween('created_at', [now()->subDays(30), now()])
				   ->where('status', 'Rejected')
				   ->orderBy('created_at')->get()->groupBy(function($journal) {
					   return $journal->created_at->format('d-M');
				   });
		});

		$data = [];
		foreach($journals as $date => $journal) {
			$data[$date] = $journal->count();
		}

		return response()->json($data);
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
