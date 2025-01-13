<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\CustomerProfit;
use App\Models\Customer;
use App\Models\IpBlock;
use App\Models\WholesellCustomer;
use App\Models\RegistrationCharge;
use App\Models\SellerWithdraw;
use App\Models\Order;
use Carbon\Carbon;
use Toastr;
use Image;
use File;
use Auth;
use Hash;

class WholeSellerManageController extends Controller
{
    public function index(Request $request){
        $show_data = Customer::where(['seller_type'=> 1, 'status'=>'active'])->orWhere('phone',$request->keyword)->orWhere('name',$request->keyword)->paginate(20);
        //return $show_data;
        return view('backEnd.wholesellercustomer.index',compact('show_data'));
    }
    public function wholesellers(Request $request){
        $show_data = Customer::where('seller_type', 2)->orWhere('phone',$request->keyword)->orWhere('name',$request->keyword)->paginate(20);
        //return $show_data;
        return view('backEnd.wholesellercustomer.wholeseller',compact('show_data'));
    }

    public function request(Request $request){
        $show_data = WholesellCustomer::where('status', 'pending')->with('customer')->paginate(20);
       // return $show_data;
        return view('backEnd.wholesellercustomer.request',compact('show_data'));
    }

    public function show(Request $request){
        $show_data = WholesellCustomer::where('id', $request->id)->first();

        $package = RegistrationCharge::find($show_data->package_id);

        return view('backEnd.wholesellercustomer.show',compact('show_data','package'));
    }


 
    public function inactive(Request $request){
        $inactive = Customer::find($request->hidden_id);
        $inactive->seller_type = 1;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request){
        $active = Customer::find($request->hidden_id);
        $active->seller_type = 2;
        $active->seller_request = 0;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    
    public function profile(Request $request){
        $profile = Customer::with('orders')->with('wholesell')->find($request->id);
        // return $profile;
        $orderdetails = Order::where(['customer_id'=>$profile->id])->orderBy('id','DESC')->get();
         // return $orderdetails;
        $withdraws    = SellerWithdraw::where(['seller_id'=>$profile->id])->latest()->paginate(20);
        //return $withdraws;
        return view('backEnd.wholesellercustomer.profile',compact('profile','orderdetails','withdraws'));
        
    }
}
