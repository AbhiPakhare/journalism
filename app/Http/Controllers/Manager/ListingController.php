<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Journal;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function showFiles()
    {
        return view('manager.listofFiles');
    }

    public function listOfFiles(Request $request)
    {
        
        $files_names = Journal::with('categories:id,name')
            ->select('id','reference_id','reviewer_id','created_at','status')
            ->whereNull('reviewer_id');
        return datatables()->eloquent($files_names)
            ->editColumn('created_at', function($manager) {
                return $manager->created_at ? with(new Carbon($manager->created_at))->format('d/M/Y') : '';
            })
            ->addColumn('action', function(Journal $journal){
                $paper = $journal->getMedia()[2]->getUrl();
                return '<a href="'. $paper .'" target="_blank" class="btn btn-primary">View Paper</a>
                            <a href="journal/'.$journal->id.'/assign" target="_blank" class="btn btn-primary">Assign Paper</a>';
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

    public function showStaff()
    {
        return view('manager.listofStaff');
    }

    public function listOfStaff()
    {
        $reviewers = User::with(['role','categories:id,name'])
            ->select('id','name','email')
            ->whereHas('role', function ($query) {
                $query->where('name', Role::REVIEWER);
            });


        return datatables()->eloquent($reviewers)
            ->addColumn('role', function (User $reviewers) {
                return $reviewers->role ? $reviewers->role->name : '';
            })

            ->addColumn('categories', function (User $reviewer) {
                $categories = $reviewer->categories->pluck('name');
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

        return redirect()->route('manager.show-files');
    }

}
