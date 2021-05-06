<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateManagerRequest;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index()
    {
        return view('admin.listOfManagers');
    }

    public function listOfManagers()
    {
        $managers = User::with('role:id,name,user_id')
                        ->select(['id','name','email','created_at'])
                        ->whereHas('role', function ($query) {
                            $query->where('name', Role::MANAGER);
                        });

        return datatables()->eloquent($managers)
            ->addColumn('role', function (User $manager) {
                return ($manager->role) ? $manager->role->name : '';
            })
            ->addColumn('action', function(User $manager) {

                return '<a href="manager/'. $manager->id .'/edit" target="_blank" class="btn btn-primary">Edit</a>
                        <button class="btn btn-danger btn-delete" data-name = "'.$manager->name.'" data-remote="/admin/manager/' . $manager->id .'">Delete</button>';
            })
            ->editColumn('created_at', function($manager) {
                return $manager->created_at ? with(new Carbon($manager->created_at))->format('d/M/Y') : '';
            })

            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.createManager');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreManagerRequest $request)
    {
        $manager = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                    ]);

        $role = new Role();
        $role->name = Role::MANAGER;
        $manager->save();
        $manager->role()->save($role);
        $manager->save();

        return redirect()->route('admin.manager.index');
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
     * @param User $manager
     * @return \Illuminate\Http\Response
     */
    public function edit(User $manager)
    {
        return view('admin.updateManager', compact('manager'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateManagerRequest $request, $id)
    {
        $manager = User::findOrFail($id);
        $manager->fill($request->validated());

        if ($manager->save()) {
            return redirect()->route('admin.manager.index');
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
        $manager = User::findOrFail($id);
        $manager->delete();
    }
}
