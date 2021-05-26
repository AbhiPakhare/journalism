<?php

namespace App\Http\Controllers\Manager;

use App\Role;
use App\User;
use App\Journal;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListingController extends Controller
{


	public function listOfFiles()
	{
		$journals = Journal::with(['categories:id,name','user'])
		->whereNull('reviewer_id')
		->when(request()->has('categories'), function($query) {
			$query->whereHas('categories', function($query){
				if (request()->categories !== "clear") {
					$query->where('categories.id', request()->categories);
				}
			});
		})
		->paginate(10)
		->appends(request()->query());

		$categories = Category::all();
		return view('manager.listofFiles', compact('journals','categories'));
	}

	public function showStaff()
	{
		$reviewers = User::with(['role','categories:id,name'])
			->select('id','name','email')
			->when(request()->has('categories'), function($query) {
				$query->whereHas('categories', function($query){
					if (request()->categories !== "clear") {
						$query->where('categories.id', request()->categories);
					}
				});
			})
			->whereHas('role', function ($query) {
				$query->where('name', Role::REVIEWER);
			})
			->paginate(10)
			->appends(request()->query());
		$categories = Category::all();
		return view('manager.listofStaff', compact('reviewers', 'categories'));
	}

	public function approvedJournals(Request $request)
	{

		$files_names = Journal::with(['categories:id,name','user', 'reviewer'])
						->where('status', Journal::APPROVED);
		return datatables()->eloquent($files_names)
			->editColumn('created_at', function($manager) {
				return $manager->created_at ? with(new Carbon($manager->created_at))->format('d/M/Y') : '';
			})
			->addColumn('action', function(Journal $journal){
				$title = $journal->getMedia()[0]->getUrl();
				$paper = $journal->getMedia()[3]->getUrl();
				return '<a href="'. $title .'" target="_blank" class="btn btn-primary">View Title</a> <a href="'. $paper .'" target="_blank" class="btn btn-primary">View Paper</a>';
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


	public function showJournal($id)
	{
		$journal =Journal::with('categories')->findOrFail($id);
		$journal_category = $journal->categories->pluck('id')->toArray();

		$reviewers = User::select(['id','name'])
			->whereHas('categories', function($query) use($journal_category){
				$query->whereIn('categories.id', $journal_category );
			})
			->get();

		return view('manager.showPaper', compact('journal', 'reviewers'));
	}

	public function assignJournal(Request $request)
	{
		$validate = $request->validate([
			'reviewer_id' => ['required'],
			'journal_id' => ['required'],
		]);

		$journal = Journal::with(['reviewer'])->findOrFail($request->journal_id);
		$reviewer = User::where('id', $request->reviewer_id)
			->whereHas( 'role', function ($query) {
				$query->where('name', Role::REVIEWER);
			})
			->first();
		if (!is_null($journal->reviewer_id))
		{
			return redirect()->back()->withErrors(['Paper have already assigned to '.$reviewer->name]);
		}
		$reviewer->assignedJournal()->save($journal);

		return redirect()->route('manager.list-of-files');
	}

}
