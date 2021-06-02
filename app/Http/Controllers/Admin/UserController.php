<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use App\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function dashboard()
    {
        $data['all_journals'] = Journal::count();
        $data['approved_journals'] = Journal::approved()->count();
        $data['waiting_journals'] = Journal::waiting()->count();
        $data['rejected_journals'] = Journal::rejected()->count();
        $data['pending_journals'] = Journal::pending()->count();
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
        $data['payment_pending'] = Journal::paymentPending()
                                ->where('payment_status', 0)
                                ->count();
        $data['payment_approved'] = Journal::approved()
                                ->where('payment_status', 1)
                                ->count();
        return view('admin.home',['data' => $data]);
    }

	public function journalPie(){

		$journal_stats['approved'] = Journal::approved()->count();
        $journal_stats['waiting'] = Journal::waiting()->count();
        $journal_stats['rejected'] = Journal::rejected()->count();
        $journal_stats['pending'] = Journal::pending()->count();
		$journal_stats['payment pending'] = Journal::paymentPending()->count();
		
		return response()->json($journal_stats);
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
				   ->approved()
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

	public function approvedJournals(Request $request)
	{

		$files_names = Journal::with(['categories:id,name','user', 'reviewer'])
						->approved();
		return datatables()->eloquent($files_names)
			->editColumn('created_at', function($manager) {
				return $manager->created_at ? with(new Carbon($manager->created_at))->format('d/M/Y') : '';
			})
			->addColumn('action', function(Journal $journal){
				$paper = $journal->getMedia()[3]->getUrl();
				return '<a href="'. $paper .'" target="_blank" class="btn btn-primary">View Paper</a>';
			})
			->addColumn('categories', function (Journal $files_names) {
				$categories = $files_names->categories->pluck('name');
				$all_categories = [];
				foreach ($categories as $category) {
					array_push($all_categories, "<span class='badge rounded-pill bg-dark text-white'>$category</span>");
				}
				return implode(" ",$all_categories);

			})
			->escapeColumns('categories')
			->toJson();

	}
}
