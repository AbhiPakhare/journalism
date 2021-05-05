<?php

namespace App\Http\Controllers\User;

use App\Journal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.createJournal');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $x = $request->validate([
            'title' =>'required|mimes:pdf|max:5000',

        ]);
        if($request->hasFile('title')) {
            return $this->tempFileSave($request->file('title'));
        }
        elseif ($request->hasFile('content')) {
            return $this->tempFileSave($request->file('content'));
        }
        elseif ($request->hasFile('paper')) {
            return $this->tempFileSave($request->file('paper'));
        }
        elseif ($request->hasFile('bibliography')) {
            return $this->tempFileSave($request->file('bibliography'));
        }
    }

    public function tempFileSave($file) {
        
        $folder = auth()->user()->id;
        $titleFileName = $file->getClientOriginalName();
        $x = $file->storeAs('journal/temp/'.$folder,$titleFileName);
        return $folder;
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
