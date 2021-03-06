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
                            ->whereReviewerId(auth()->user()->id)
							->latest()
                            ->paginate(10);
        return view('reviewer.index', compact('journals'));
    }

    public function myWorkStats($status)
    {
        $journals = Journal::whereReviewerId(auth()->user()->id)
                            ->latest();
        if ($status == "approved") {
            $journals = $journals->whereStatus(Journal::APPROVED);
        }elseif ($status == "rejected"){
            $journals = $journals->whereStatus(Journal::REJECTED);
        }elseif ($status == "waiting") {
            $journals = $journals->whereStatus(Journal::WAITING);
        }else{
            abort(403,'Hey you have entered wrong URL');
        }
        $journals = $journals->paginate(10);

        return view('reviewer.reviewerWork', compact('journals', 'status'));
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
		$journal->status = $request->status == Journal::APPROVED 
							? Journal::PENDING_PAYMENT 
							: $request->status;

        $journal->reason = $request->reason ?? null;
		
        if($request->status == Journal::APPROVED){
            $params = [
                'user_id' => $journal->user->id,
                'journal_id' => $journal->id
            ];
            $url = Crypt::encrypt($params);
			$journal->payment_link = $url;
            $journal->user->notify(new JournalApprovedNotify($journal->user, $request->status, $journal,$url));
        }else{
            $journal->user->notify(new JournalStatusNotify($journal->user, $request->status , $journal->reference_id, $request->reason));
        }
        $journal->save();

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
