<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\IpBlock;
use App\Models\Income;
use App\Models\Seller;
use App\Models\SellerWithdrawVentor;
use App\Models\Expense;
use App\Models\Transaction;
use Carbon\Carbon;
use Toastr;
use Image;
use File;
use Auth;
use Hash;

class VentorwithdrawController extends Controller
{
    public function ventorwithdraw($status,Request $request){
        $title = $status;
        $sellers = Seller::where(['status'=>'active'])->select('id','name','status')->get();
        $withdraws = SellerWithdrawVentor::where(['status'=>$status]);
         if ($request->seller_id) {
            $withdraws = $withdraws->where('seller_id', $request->seller_id);
        }
        if ($request->start_date && $request->end_date) {
            $withdraws =$withdraws->whereBetween('created_at', [$request->start_date,$request->end_date]);
        }
        $withdraws = $withdraws->paginate(100);
       // return $withdraws;
        return view('backEnd.ventor.withdraw',compact('title','withdraws','sellers'));
    }

    public function ventorwithdraw_change(Request $request){

        $seller = SellerWithdrawVentor::find($request->id);
        $seller->status = $request->status;
        $seller->note = $seller->note;
        //return $seller;
        $seller->save();
        $seller_name = Seller::select()->find($seller->seller_id);
        if($request->status == 'paid'){
            $balance = Seller::find($seller->seller_id);
            $balance->balance -= $seller->amount;
            $balance->withdraw += $seller->amount;
            $balance->save();

            $transaction_data = Transaction::create([
                'user_id'     => $balance->id,
                'user_type'   => 'seller',
                'amount'      => $seller->amount,
                'balance'     => $balance->balance,
                'amount_type' => 'debit', 
                'note'        => 'withdraw',
                'status'      => 'complete',
            ]);
            
            $expense = new Expense();
            $expense->name = 'Withdraw paid of - '. $seller_name->name;
            $expense->expense_cat_id = 5;
            $expense->amount = $seller->amount;
            $expense->note = $seller->note;
            $expense->date = Carbon::now();
            $expense->status = 1;
            $expense->save();
        }
        Toastr::success('Success','Withdraw status change successfully');
        return redirect()->back();
    }


}
