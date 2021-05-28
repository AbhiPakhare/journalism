<?php

namespace App\Http\Controllers\User;

use App\Journal;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\ReferencesIdCreated;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class JournalController extends Controller
{
    public function dashboard()
    {
        if (session('success_message')) {
            Alert::success('Success!', session('success_message'));
        }
         return view('user.home');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($status = "index")
	{
		$journals = Journal::where('user_id', auth()->user()->id)
							->latest();
		if($status == "pending"){
			$journals = $journals->where('status', Journal::PENDING);
		}elseif($status == "rejected"){
			$journals = $journals->where('status', Journal::REJECTED);
		}

		$journals = $journals->paginate(10);
		return view('user.showJournal', compact('journals','status'));
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
	 * @return \Illuminate\Http\RedirectResponse
     */

	public function store(Request $request){

		$reference_id = time();
		$journal = Journal::firstOrCreate([
								'user_id' => auth()->user()->id,
								'reference_id' => $reference_id
							]);

		$journal->addMedia($this->checkJournalFileType('title')) // 0
				->toMediaCollection();
		$journal->addMedia($this->checkJournalFileType('content')) //1
				->toMediaCollection();
		$journal->addMedia($this->checkJournalFileType('bibliography')) //3
				->toMediaCollection();
		$journal->addMedia($this->checkJournalFileType('paper'))// 2
				->toMediaCollection();

		$journal->categories()->sync([$request->category]);
		if($journal) {
			$journal->user->notify(new ReferencesIdCreated($journal->user, $reference_id));
			return redirect()
                ->route('user.dashboard')
                ->withSuccessMessage('Journals submitted successfully with refernce ID'.$reference_id);
		}else{
			abort(403,"Some issue occurred contact Admin");
		}

	}

    public function checkJournalFileType($file_name)
    {
        if (Storage::disk('local')->exists('journal/temp/'.auth()->user()->id.'/'.$file_name.'.pdf'))
        {
            return storage_path('app/journal/temp/'.auth()->user()->id.'/'.$file_name.'.pdf');
        }
        elseif (Storage::disk('local')->exists('journal/temp/'.auth()->user()->id.'/'.$file_name.'.doc'))
        {
            return storage_path('app/journal/temp/'.auth()->user()->id.'/'.$file_name.'.doc');
        }
        elseif (Storage::disk('local')->exists('journal/temp/'.auth()->user()->id.'/'.$file_name.'.docx'))
        {
            return storage_path('app/journal/temp/'.auth()->user()->id.'/'.$file_name.'.docx');
        }
        else
        {
            abort(403, 'File Type does not exist');
        }
	}

	public function storeJournal(Request $request)
	{
		try {
			if($request->hasFile('title')) {
				$request->file('title')->storeAs('journal/temp/'.auth()->user()->id,'/title.'.$request->file('title')->extension());
			}
			elseif ($request->hasFile('content')) {
				$request->file('content')->storeAs('journal/temp/'.auth()->user()->id,'/content.'.$request->file('content')->extension());
			}
			elseif ($request->hasFile('paper')) {
				$request->file('paper')->storeAs('journal/temp/'.auth()->user()->id,'/paper.'.$request->file('paper')->extension());
			}
			elseif ($request->hasFile('bibliography')) {
				$request->file('bibliography')->storeAs('journal/temp/'.auth()->user()->id,'/bibliography.'.$request->file('bibliography')->extension());
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

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Journal  $journal
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Journal $journal)
	{
		return view('user.editJournal', compact('journal'));
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
		foreach ($journal->getMedia() as $media) {
			if($media->name == "paper") {
				$media->delete();
			}
		}

		$journal->addMedia($this->checkJournalFileType('paper'))
			->toMediaCollection();

		$journal->status = Journal::WAITING;
		$journal->save();

		if($journal) {
			return redirect()->route('user.journal.index');
		}else{
			abort(403,"Some issue occured contact Admin");
		}

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
