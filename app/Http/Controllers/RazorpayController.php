<?php

namespace App\Http\Controllers;

use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Razorpay\Api\Api;
use Session;
use Redirect;
class RazorpayController extends Controller
{
    public function razorpay($url)
    {
        try {
            $url = Crypt::decrypt($url);
        }
        catch (\Throwable $exception) {
           return redirect()->back()->withErrors('Payment link is wrong');
        }

        $journal = Journal::with('user')->findOrFail($url['journal_id']);

        if ($journal->user->id !== (int) $url['user_id']){
            return redirect()
                    ->route('user.journal.index')
                    ->withErrors(['You are not authorized to make payment for this journal']);
        }

        return view('payment.payment', compact('journal'));
    }

    public function payment(Request $request)
    {
        $input = $request->all();
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id']))
        {
            try
            {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
            }
            catch (\Exception $e)
            {
                return redirect()->route('user.journal.index')->with('status', $e->getMessage());
            }
            $journal = Journal::findOrFail($input['journal_id']);
            $journal->payment_status = true;
			$journal->status = Journal::APPROVED;
			$journal->payment_link = null;
            $journal->save();
        }

        return redirect()->route('user.journal.index')->with('status','Payment Done Successful');
    }
}
