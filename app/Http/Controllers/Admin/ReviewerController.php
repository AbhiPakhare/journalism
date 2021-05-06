<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewerRequest;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ReviewerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.listOfReviewers');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('id','name')->get();
        return view('admin.createReviewer', compact('categories'));
    }

    public function listOfReviewers()
    {
        $reviewers = User::with(['role','categories:id,name'])
                    ->select('id','name','email','created_at')
                    ->whereHas('role', function ($query) {
                        $query->where('name', Role::REVIEWER);
                    });


        return datatables()->eloquent($reviewers)
            ->addColumn('role', function (User $reviewers) {
                return $reviewers->role ? $reviewers->role->name : '';
            })
            ->addColumn('action', function(User $reviewer) {
                return '<a href="reviewer/'. $reviewer->id .'/edit" target="_blank" class="btn btn-primary">Edit</a>
                        <button class="btn btn-danger btn-delete"  data-remote="/admin/reviewer/' . $reviewer->id .'">Delete</button>';
            })
            ->addColumn('categories', function (User $reviewer) {
                $categories = $reviewer->categories->pluck('name');
                $all_categories = [];
                foreach ($categories as $category) {
                    array_push($all_categories, "<span class='badge rounded-pill bg-dark text-white'>$category</span>");
                }
                return implode(" ",$all_categories);

            })
            ->editColumn('created_at', function($reviewers) {
                return $reviewers->created_at ? with(new Carbon($reviewers->created_at))->format('d/M/Y') : '';
            })
            ->escapeColumns('categories')
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReviewerRequest $request)
    {
        $manager = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = new Role();
        $role->name = Role::REVIEWER;
        $manager->role()->save($role);
        $manager->save();
        $manager->categories()->sync($request->categories);
        $manager->save();

        return redirect()->route('admin.reviewer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reviewer = User::findOrFail($id);
        $reviewer->delete();
    }
}
