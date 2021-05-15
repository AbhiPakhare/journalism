<?php

namespace App\Http\Controllers;

use Session;
use Redirect;
use App\Journal;
use Razorpay\Api\Api;
use Illuminate\Http\Request;

class RazorpayController extends Controller
{
    public function razorpay($id)
    {	
		$journal = Journal::with(['user'])->findOrFail($id);
		if(auth()->user()->id !== $journal->user->id) {
			return redirect()
				->route('user.dashboard')
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
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->route('user.journal.index');
            }
        }

        \Session::put('success', 'Payment successful, your order will be despatched in the next 48 hours.');
        return redirect()->back();
    }
}
