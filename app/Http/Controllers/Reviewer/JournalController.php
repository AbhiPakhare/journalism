<?php

namespace App\Http\Controllers\Reviewer;

use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Notifications\JournalStatusNotify;
use App\Notifications\JournalApprovedNotify;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journals = Journal::whereStatus(Journal::WAITING)
                            ->whereReviewerId (auth()->user()->id)
							->latest()
                            ->paginate(15);
        return view('reviewer.index', compact('journals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param Journal $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
    {
        $paper = $journal->getMedia()[3]->getUrl();
        return view('reviewer.checkJournal', compact('journal','paper'));
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
        $validate = $request->validate([
            'status' => [
                'required',
                Rule::in('Approved', 'Rejected','Pending'),
                'string'
                ],
            'reason' => [
                Rule::requiredIf(function () use($request) {
                    return in_array($request->status, ['Rejected','Pending']);
                })
            ]
        ]);
        $journal = Journal::findOrFail($id);
        $journal->status = $request->status;
        $journal->reason = $request->reason ?? null;
        $journal->save();
        if($request->status == 'Approved'){
            $params = [
                'user_id' => $journal->user->id,
                'journal_id' => $journal->id
            ];
            $url = Crypt::encrypt($params);
            $journal->user->notify(new JournalApprovedNotify($journal->user, $request->status, $journal,$url));
        }else{
            $journal->user->notify(new JournalStatusNotify($journal->user, $request->status , $journal->reference_id, $request->reason));
        }

        return redirect()->route('reviewer.journal.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
