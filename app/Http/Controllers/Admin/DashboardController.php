<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\SellerWithdraw;
use App\Models\OrderDetails;
use App\Models\WholesellCustomer;
use App\Models\Seller;
use Carbon\Carbon;
use Session;
use Toastr;
use Auth;
use DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->except(['locked','unlocked']);
    }
    public function dashboard(Request $request){
        if ($request->start_date && $request->end_date) {
            $total_order = Order::whereBetween('created_at', [$request->start_date,$request->end_date])->count();
            $total_delivery = Order::where('order_status','6')->whereBetween('created_at', [$request->start_date,$request->end_date])->count();
            $total_process = Order::whereNotIn('order_status',['1','6','7','8'])->whereBetween('created_at', [$request->start_date,$request->end_date])->count();
            $total_return = Order::where('order_status','8')->whereBetween('created_at', [$request->start_date,$request->end_date])->count();
            $total_complete = Order::where('order_status','6')->whereBetween('created_at', [$request->start_date,$request->end_date])->count();
            $total_amount = Order::whereBetween('created_at', [$request->start_date,$request->end_date])->sum('amount');








            $total_re_request = Customer::where(['seller_type' => '1', 'status' => 'pending'])->whereBetween('created_at', [$request->start_date,$request->end_date])->count();
            $total_withdraw = SellerWithdraw::where(['status' => 'paid'])->whereBetween('created_at', [$request->start_date,$request->end_date])->sum('amount');
            $reseller_cash = Customer::where('seller_type', 1)->whereBetween('created_at', [$request->start_date,$request->end_date])->sum('balance');


            $total_expense = Expense::where('status', 1)->whereBetween('created_at', [$request->start_date,$request->end_date])->sum('amount');
            $total_purchase = OrderDetails::whereHas('order', function($query) use ($request) {
                $query->where('order_status', 6)
                ->whereBetween('created_at', [$request->start_date,$request->end_date]);
            })->sum(DB::raw('purchase_price * qty'));

            $total_sales = OrderDetails::whereHas('order', function($query) use($request) {
                $query->where('order_status', 6)
                ->whereBetween('created_at', [$request->start_date,$request->end_date]);
            })->sum(DB::raw('sale_price * qty'));
            $total_income = WholesellCustomer::where('status','paid')
                ->whereBetween('created_at', [$request->start_date,$request->end_date])->sum('amount');





            $delivery_amount = Order::where('order_status','6')->whereBetween('created_at', [$request->start_date,$request->end_date])->sum('amount');
            $process_amount = Order::whereNotIn('order_status',['1','6','7','8'])->whereBetween('created_at', [$request->start_date,$request->end_date])->sum('amount');
            $return_amount = Order::where('order_status','8')->whereBetween('created_at', [$request->start_date,$request->end_date])->sum('amount');
            $today_order = Order::where('created_at', '>=', Carbon::today())->count();
            $total_product = Product::whereBetween('created_at', [$request->start_date,$request->end_date])->count();
            $total_customer = Customer::whereBetween('created_at', [$request->start_date,$request->end_date])->count();
            $latest_order = Order::latest()->limit(5)->with('customer','product','product.image')->whereBetween('created_at', [$request->start_date,$request->end_date])->get();
            $latest_customer = Customer::latest()->limit(5)->get();
        }else{
            $total_order = Order::count();
            $total_delivery = Order::where('order_status','6')->count();
            $total_process = Order::whereNotIn('order_status',['1','6','7','8'])->count();
            $total_return = Order::where('order_status','8')->count();
            $total_complete = Order::where('order_status','6')->count();
            $total_re_request = Customer::where(['seller_type' => '1', 'status' => 'pending'])->count();
            $total_withdraw = SellerWithdraw::where(['status' => 'paid'])->sum('amount');
            $reseller_cash = Customer::where('seller_type', 1)->sum('balance');
            $seller_cash = Seller::sum('balance');
            $seller_earning = Order::where('order_status', 6)->sum('seller_commission');


            $total_expense = Expense::where('status', 1)->sum('amount');

            $total_purchase = OrderDetails::whereHas('order', function($query) {
                $query->where('order_status', 6);
            })->sum(DB::raw('purchase_price * qty'));

            $total_sales = OrderDetails::whereHas('order', function($query) {
                $query->where('order_status', 6);
            })->sum(DB::raw('sale_price * qty'));

            $total_income = WholesellCustomer::where('status','paid')->sum('amount');




            $total_amount = Order::sum('amount');
            $delivery_amount = Order::where('order_status','6')->sum('amount');
            $process_amount = Order::whereNotIn('order_status',['1','6','7','8'])->sum('amount');
            $return_amount = Order::where('order_status','8')->sum('amount');
            $today_order = Order::where('created_at', '>=', Carbon::today())->count();
            $total_product = Product::count();
            $total_customer = Customer::count();
            $latest_order = Order::latest()->limit(5)->with('customer','product','product.image')->get();
            $latest_customer = Customer::latest()->limit(5)->get();
        }


        return view('backEnd.admin.dashboard',compact('total_order','total_return','total_process','total_complete','today_order','total_product','total_customer','latest_order','latest_customer','total_delivery','total_amount','delivery_amount','process_amount','return_amount','total_re_request','total_withdraw','reseller_cash','total_expense','total_purchase','total_sales','total_income','seller_cash','seller_earning'));
    }
    public function changepassword(){
        return view('backEnd.admin.changepassword');
    }
     public function newpassword(Request $request)
    {
        $this->validate($request, [
            'old_password'=>'required',
            'new_password'=>'required',
            'confirm_password' => 'required_with:new_password|same:new_password|'
        ]);

        $user = User::find(Auth::id());
        $hashPass = $user->password;

        if (Hash::check($request->old_password, $hashPass)) {

            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            Toastr::success('Success', 'Password changed successfully!');
            return redirect()->route('dashboard');
        }else{
            Toastr::error('Failed', 'Old password not match!');
            return back();
        }
    }
    public function locked(){
        // only if user is logged in

            Session::put('locked', true);
            return view('backEnd.auth.locked');


        return redirect()->route('login');
    }

    public function unlocked(Request $request)
    {
        if(!Auth::check())
            return redirect()->route('login');
        $password = $request->password;
        if(Hash::check($password,Auth::user()->password)){
            Session::forget('locked');
            Toastr::success('Success', 'You are logged in successfully!');
            return redirect()->route('dashboard');
        }
        Toastr::error('Failed', 'Your password not match!');
        return back();
    }
}
