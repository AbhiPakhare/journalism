<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Journal;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function showFiles()
    {
        return view('manager.listofFiles');
    }

    public function listOfFiles()
    {
        $files_names = Journal::with('categories:id,name')
                                ->select('id','reference_id');

        return datatables()->eloquent($files_names)
                ->addColumn('File Name',function(Journal $files_names){
                    $paper = $files_names->getMedia()[2]['file_name'];
                    return $paper ? $paper : '';
                })
                ->addColumn('reference_id',function(Journal $files_names){
                    return $files_names->reference_id ? $files_names->reference_id : '';
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
        // dd($reviewers->toArray());

        return view('manager.showJournal', compact('journal', 'reviewers'));
    }

    public function assignJournal(Request $request)
    {
       $validate = $request->validate([
           'reviewer' => ['required', 'string', 'max:255'],
           'journal_id' => ['required', 'integer'],
       ]);

       dd($validate);
    }

}
