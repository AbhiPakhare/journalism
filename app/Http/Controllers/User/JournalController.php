<?php

namespace App\Http\Controllers\User;

use App\Journal;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('user.createJournal', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
        $reference_id = time();
        $journal = Journal::firstOrCreate([
                                'user_id' => auth()->user()->id,
                                'reference_id' => $reference_id
                            ]);

        $journal->addMedia(storage_path('app/journal/temp/title.pdf'))
                ->toMediaCollection();
                    
        $journal->addMedia(storage_path('app/journal/temp/content.pdf'))
                ->toMediaCollection();

        $journal->addMedia(storage_path('app/journal/temp/paper.pdf'))
                ->toMediaCollection();

        $journal->addMedia(storage_path('app/journal/temp/bibliography.pdf'))
                ->toMediaCollection();    

        if($journal) {
            return redirect()->route('user.dashboard');
        }else{
            abort(403,"Some issue occured contact Admin");
        }

    }


    public function storeJournal(Request $request)
    {
        try {
            if($request->hasFile('title')) {
                $request->file('title')->storeAs('journal/temp/','title.pdf');
            }
            elseif ($request->hasFile('content')) {
                $request->file('content')->storeAs('journal/temp/','content.pdf');
            }
            elseif ($request->hasFile('paper')) {
                $request->file('paper')->storeAs('journal/temp/','paper.pdf');
            }
            elseif ($request->hasFile('bibliography')) {
                $request->file('bibliography')->storeAs('journal/temp/','bibliography.pdf');
            }
        } catch (\Throwable $th) {
            return $th;
        }

    }

    


    /**
     * Display the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Journal $journal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Journal $journal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        //
    }
}
