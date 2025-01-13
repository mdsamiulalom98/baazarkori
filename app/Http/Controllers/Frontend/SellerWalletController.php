<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentGateway;
use App\Models\Seller;
use App\Models\Transaction;
use App\Models\Wallet;

class SellerWalletController extends Controller
{
    public function sellerwallet_add(){
       $bkash_gateway = PaymentGateway::where(['status' => 1, 'type' => 'bkash'])->first();
       $shurjopay_gateway = PaymentGateway::where(['status' => 1, 'type' => 'shurjopay'])->first();

       return view('frontEnd.seller.pages.wallet_add',compact('bkash_gateway','shurjopay_gateway'));
   }
    public function sellerwallet_save(Request $request){
        $this->validate($request,[
            'amount'=>'required',
            'payment_method'=>'required',
        ]);
              
        $payment                 = new Wallet();
        $payment->customer_id    = Auth::guard('seller')->user()->id;
        $payment->name           = Auth::guard('seller')->user()->name ;
        $payment->email          = Auth::guard('seller')->user()->email ;
        $payment->phone          = Auth::guard('seller')->user()->phone;
        $payment->payment_method = $request->payment_method;
        $payment->sender_number  = $request->sender_number;
        $payment->transaction    = $request->transaction;
        $payment->amount         = $request->amount;
        $payment->wallets_type   = 'seller';
        $payment->status         = 'pending';
        //return $payment;
        $payment->save();
        return redirect()->route('seller.sellerwallet');
       
        
    }
    public function sellerwallet(){
        // $wallet = Wallet::select('id','phone','name','amount','status','updated_at')->where('customer_id',Auth::guard('seller')->user()->id)->get();
         // return $wallet;
        $wallet = Transaction::where('user_id', Auth::guard('seller')->user()->id)->get();
        //  return $wallet;
       return view('frontEnd.seller.pages.wallet',compact('wallet'));
   }
}
