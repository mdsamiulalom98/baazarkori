<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\CustomerProfit;
use App\Models\Customer;
use App\Models\Order;
use App\Models\IpBlock;
use App\Models\SellerWithdraw;
use App\Models\seller;
use App\Models\Customerdeduct;
use App\Models\Customeraddamount;
use App\Models\RegistrationCharge;
use App\Models\WholesellCustomer;
use App\Models\Transaction;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Packaging;
use App\Models\Boost;
use Carbon\Carbon;
use Toastr;
use Image;
use File;
use Auth;
use Hash;
class CustomerManageController extends Controller
{
    public function index(Request $request){

         // $expires = Customer::where(['seller_type' => $request->type,'activation'=>'expired'])->get();
         // foreach($expires as $key=>$expire){
         //    $date =  $expire->created_at->addDays('30');
         //    $expire->activation = $date->format('Y-m-d');
         //    $expire->save();
         // }
        $currentDate = Carbon::now()->format('Y-m-d');  
        $show_data   = Customer::where(['seller_type' => $request->type,'status'=>$request->status]);

        if($request->keyword){
            $show_data->orWhere('phone',$request->keyword)->orWhere('name',$request->keyword);
        }
        
        if($request->activation == 'expired'){
            $show_data->where('activation', '<', $currentDate);
        }
        // return $show_data->get();
        $show_data = $show_data->latest();
         //return $show_data->get();
        $show_data = $show_data->paginate(100)->withQueryString();

        return view('backEnd.customer.index',compact('show_data'));
    } 
    
    public function edit($id){
        $edit_data = Customer::find($id);
        return view('backEnd.customer.edit',compact('edit_data'));
    }
    
    public function update(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        $input = $request->except('hidden_id');
        $update_data = Customer::find($request->hidden_id);
        // new password
        
        
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }

        // new image
        $image = $request->file('image');
        if($image){
            // image with intervention 
            $name =  time().'-'.$image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/customer/';
            $imageUrl = $uploadpath.$name; 
            $img=Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = 100;
            $height = 100;
            $img->height() > $img->width() ? $width=null : $height=null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($imageUrl);
            $input['image'] = $imageUrl;
            File::delete($update_data->image);
        }else{
            $input['image'] = $update_data->image;
        }
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('customers.index');
    }
 
    public function inactive(Request $request){
        $inactive = Customer::find($request->hidden_id);
        $inactive->status = 'inactive';
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request){
        $active = Customer::find($request->hidden_id);
        $active->status = 'active';
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function profile(Request $request){

        $profile = Customer::with('orders')->find($request->id);
         //return $profile;

        $orderdetails = Order::where(['customer_id'=>$profile->id])->orderBy('id','DESC')->get();
         // return $orderdetails;
        $withdraws    = SellerWithdraw::where(['seller_id'=>$profile->id])->latest()->paginate(50);

        return view('backEnd.customer.profile',compact('profile','orderdetails','withdraws'));
    }
    public function adminlog(Request $request){
        $customer = Customer::find($request->hidden_id);
        Auth::guard('customer')->loginUsingId($customer->id);
        return redirect()->route('customer.dashboard');
    }
    public function ip_block(Request $request){
        $data = IpBlock::get();
        return view('backEnd.reports.ipblock',compact('data'));
    }
    public function ipblock_store(Request $request){

        $store_data = new IpBlock();
        $store_data->ip_no = $request->ip_no;
        $store_data->reason = $request->reason;
        $store_data->save();
        Toastr::success('Success','IP address add successfully');
        return redirect()->back();
    }
    public function ipblock_update(Request $request){
        $update_data = IpBlock::find($request->id);
        $update_data->ip_no = $request->ip_no;
        $update_data->reason = $request->reason;
        $update_data->save();
        Toastr::success('Success','IP address update successfully');
        return redirect()->back();
    }
    public function ipblock_destroy(Request $request){
        $delete_data = IpBlock::find($request->id)->delete();
        Toastr::success('Success','IP address delete successfully');
        return redirect()->back();
    }
    public function withdraw($status,Request $request){
        $title = $status;
        $sellers = Customer::where(['status'=>'active'])->select('id','name','status')->get();
        $withdraws = SellerWithdraw::where(['status'=>$status]);
         if ($request->seller_id) {
            $withdraws = $withdraws->where('seller_id', $request->seller_id);
        }
        if ($request->start_date && $request->end_date) {
            $withdraws =$withdraws->whereBetween('created_at', [$request->start_date,$request->end_date]);
        }
        $withdraws = $withdraws->paginate(100);
        return view('backEnd.customer.withdraw',compact('title','withdraws','sellers'));
    }
    public function withdraw_change(Request $request){

        $seller = SellerWithdraw::find($request->id);
        $seller->status = $request->status;
        $seller->admin_note = $request->admin_note;
        $seller->save();
        $seller_name = Customer::select()->find($seller->seller_id);
        if($request->status == 'paid'){
            $balance = Customer::find($seller->seller_id);
            $balance->balance -= $seller->amount;
            $balance->withdraw += $seller->amount;
            $balance->save();

            $transaction_data = Transaction::create([
                'user_id'     => $balance->id,
                'user_type'   => 'customer',
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
            $expense->note = $request->admin_note;
            $expense->date = Carbon::now();
            $expense->status = 1;
            $expense->save();
        }
        Toastr::success('Success','Withdraw status change successfully');
        return redirect()->back();
    }
    public function slip($invoice_id){
        $slip_data = SellerWithdraw::where(['id'=>$invoice_id])->with('customer')->firstOrFail();
        return view('backEnd.customer.slip',compact('slip_data'));
    }
    public function payment(Request $request){
        $show_data = WholesellCustomer::where('status',$request->status)->latest()->paginate(50);
        return view('backEnd.customer.payment',compact('show_data'));
    }
    public function payment_show(Request $request){
        $show_data = WholesellCustomer::with('customer')->find($request->id);
        $package = RegistrationCharge::select('id','title')->find($show_data->package_id);
        return view('backEnd.customer.payment_show',compact('show_data','package'));
    }
    public function payment_status(Request $request){
        $active = WholesellCustomer::find($request->id);
        $active->status = $request->status;
        $active->save();

        if($request->status == 'paid') {
            $package = RegistrationCharge::find($active->package_id);
            $daysToAdd = $package->days;
            $currentDate = Carbon::now();
            $newDate = $currentDate->addDays($daysToAdd);
            $newDate = $newDate->toDateString();
            
            $customer = Customer::find($active->customer_id);
            $customer->seller_type = $active->type;
            $customer->seller_request = 0;
            $customer->activation = $newDate;
            $customer->status = 'active';
            $customer->save();
            
            // refer seller
            $payment = WholesellCustomer::where('customer_id', $customer->id)->count();
            if($payment == 1 && $customer->refferal_1) {
                $referer = Customer::find($customer->refferal_1);
                $referer->balance += ($package->charge * 20) / 100;
                $referer->save();
            }
            $income = new Income();
            $income->name = 'Accout fee of - '. $customer->name;
            $income->category_id = 1;
            $income->amount = $active->amount;
            $income->note = 'Accout fee of - '. $customer->name;
            $income->date = Carbon::now();
            $income->status = 1;
            $income->save();
            
            
        }
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }

    public function polyorders(Request $request){
        $show_data = Packaging::where('status',$request->status)->latest()->paginate(50);
        //return $show_data;
        return view('backEnd.polyorder.orders',compact('show_data'));
    }

    public function order_details(Request $request){
        $show_data = Packaging::find($request->id);
       // return $show_data;
        return view('backEnd.polyorder.order_details',compact('show_data'));
    }

    public function poly_status(Request $request){
        $active = Packaging::find($request->id);
        $active->status = $request->status;
        // return $active;
        $active->save();

        if($request->status == 'cancelled') {
            
            $seller = Seller::find($active->seller_id);
            $seller->balance += $active->amount;
            //return $seller;
            $seller->save(); 

            $transaction_data = Transaction::create([
                'user_id'     => $seller->id,
                'user_type'   => 'seller',
                'amount'      => $active->amount,
                'balance'     => $seller->balance,
                'amount_type' => 'credit', 
                'note'        => 'Refund PolyBeg Order',
                'status'      => 'cancelled',
            ]);
        } 



        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }


    public function boostorders(Request $request){
        $show_data = Boost::where('status', $request->status)->latest()->paginate(50);
        // return $show_data;
        return view('backEnd.boostorder.orders',compact('show_data'));
    }

    public function boost_details(Request $request){
        $show_data = Boost::find($request->id);
       // return $show_data;
        return view('backEnd.boostorder.boost_details',compact('show_data'));
    }

    public function boost_status(Request $request){
        $active = Boost::find($request->id);
        $active->status = $request->status;
         // return $active;
        $active->save();

        if($request->status == 'cancelled') {
            if ($active->user_type == 'customer') {
                $seller = Customer::find($active->user_id);
                $seller->balance += $active->amount;
                // return $seller;
                $seller->save(); 

                $transaction_data = Transaction::create([
                    'user_id'     => $seller->id,
                    'user_type'   => 'customer',
                    'amount'      => $active->amount,
                    'balance'     => $seller->balance,
                    'amount_type' => 'credit', 
                    'note'        => 'Refund Boost Order',
                    'status'      => 'cancelled',
                ]);


            }else{
                $seller = Seller::find($active->user_id);
                $seller->balance += $active->amount;
                // return $seller;
                $seller->save(); 

                $transaction_data = Transaction::create([
                    'user_id'     => $seller->id,
                    'user_type'   => 'seller',
                    'amount'      => $active->amount,
                    'balance'     => $seller->balance,
                    'amount_type' => 'credit', 
                    'note'        => 'Refund Boost Order',
                    'status'      => 'cancelled',
                ]);
            }

        }   

        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }


    public function storecus(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'note' => 'required',
        ]);
        $input = $request->all();
        $customer = Customer::find($request->customer_id);
        $customer->balance -= $request->amount;
        $customer->save();

        $input['amount'] = $request->amount;
        $input['note']   = $request->note;
        $input['status'] = 'active';
        //return $input;
        Customerdeduct::create($input);

        $transaction_data = Transaction::create([
            'user_id'     => $customer->id,
            'user_type'   => 'customer',
            'amount'      => $request->amount,
            'balance'     => $customer->balance,
            'amount_type' => 'debit', 
            'note'        => 'admin amount (-)',
            'status'      => 'complete',
        ]);


        Toastr::success('Success','Data insert successfully');
        return redirect()->back();
    }

    public function addstorecus(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'note' => 'required',
        ]);
        $input = $request->all();
        $customer = Customer::find($request->customer_id);
        $customer->balance += $request->amount;
        // return $customer;
         $customer->save();

        $input['amount'] = $request->amount;
        $input['note'] = $request->note;
        $input['status'] = 'pending';

        Customeraddamount::create($input);

        $transaction_data = Transaction::create([
            'user_id'     => $customer->id,
            'user_type'   => 'customer',
            'amount'      => $request->amount,
            'balance'     => $customer->balance,
            'amount_type' => 'credit', 
            'note'        => 'admin add balance',
            'status'      => 'complete',
        ]);


        Toastr::success('Success','data insert successfully');
        return redirect()->back();
    }

    public function changecus(Request $request)
    {
        $customerId = Auth::guard('customer')->user()->id;

        $change = Customerdeduct::where('customer_id', $customerId)
                          ->where('status', 'pending')
                          ->first();
        if ($change) {
            $change->status = 'active';
            $change->save();
            Toastr::success('Success', 'Data activated successfully');
        } else {
            Toastr::error('Error', 'Record not found');
        }
        return redirect()->back();
    }
    





    
    
}
