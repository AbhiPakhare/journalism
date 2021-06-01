<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreReviewerRequest;
use App\Http\Requests\UpdateReviewerRequest;

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
     * @return
     */
    public function create()
    {
        $categories = Category::select('id','name')->get();
        return view('admin.createReviewer', compact('categories'));
    }

    public function listOfReviewers(): \Illuminate\Http\JsonResponse
    {
        $reviewers = User::with(['categories:id,name'])
                    ->select('id','name','email','created_at')
                    ->whereHas('role', function ($query) {
                        $query->where('name', Role::REVIEWER);
                    });


        return datatables()->eloquent($reviewers)
            ->addColumn('action', function(User $reviewer) {
                return '<a href="reviewer/'. $reviewer->id .'/edit" target="_blank" class="btn btn-primary">Edit</a>
                        <button class="btn btn-danger btn-delete"  data-remote="/admin/reviewer/' . $reviewer->id .'">Delete</button>';
            })
            ->addColumn('categories', function (User $reviewer) {
                $categories = $reviewer->categories->pluck('name')->toArray();
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
		$request->validate([
			'name' => ['required'],
			'email' => ['required', 'email:rfc,dns']
		]);
        $reviewer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = new Role();
        $role->name = Role::REVIEWER;
        $reviewer->role()->save($role);
        $reviewer->save();
        $reviewer->categories()->sync($request->categories);
        $reviewer->save();

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
        $reviewer = User::with('categories')->findOrFail($id);

        return view('admin.updateReviewer', compact('reviewer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReviewerRequest $request
     * @param User $reviewer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReviewerRequest $request, User $reviewer)
    {
        $reviewer_info = collect($request->validated())
                        ->except(['categories'])
                        ->toArray();

        $reviewer->fill($reviewer_info);
        $reviewer->categories()->sync($request->categories);
        if ($reviewer->save()) {
            return redirect()->route('admin.reviewer.index');
        }else{
            return abort(403,'some issue occured');
        }
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
