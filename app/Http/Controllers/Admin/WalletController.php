<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Seller;
use App\Models\Wallet;
use App\Models\Transaction;
use File;
use Toastr;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $data = Wallet::where('status',$request->status)->get();
        return view('backEnd.wallet.index',compact('data'));
    }
    public function status(Request $request){
        $wallet = Wallet::find($request->hidden_id);
        $old_status = $wallet->status;
        $wallet->status = $request->status;
        $wallet->save();
        if($request->status == 'paid' && $old_status != 'paid' && $wallet->wallets_type == 'customer'){
            $customer = Customer::find($wallet->customer_id);
            $customer->balance += $wallet->amount;
            $customer->save();

            $transaction_data = Transaction::create([
                'user_id'     => $customer->id,
                'user_type'   => 'customer',
                'amount'      => $wallet->amount,
                'balance'     => $customer->balance,
                'amount_type' => 'credit', 
                'note'        => 'wallet add',
                'status'      => 'complete',
            ]);

        }elseif($request->status == 'paid' && $old_status != 'paid' && $wallet->wallets_type == 'seller'){
            $seller = Seller::find($wallet->customer_id);
            $seller->balance += $wallet->amount;
            $seller->save();

            $transaction_data = Transaction::create([
                'user_id'     => $seller->id,
                'user_type'   => 'seller',
                'amount'      => $wallet->amount,
                'balance'     => $seller->balance,
                'amount_type' => 'credit', 
                'note'        => 'wallet add',
                'status'      => 'complete',
            ]);
        }
        Toastr::success('Success','Wallet amount '.$request->status.' successfully');
        return redirect()->back();
    }
    public function history(Request $request){
        $data = Customer::select('name','phone','balance','status')->where('balance','>','0')->paginate(100);
        return view('backEnd.wallet.history',compact('data'));
    }
}
