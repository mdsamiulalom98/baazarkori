<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Seller;
use App\Models\Sellerdeduct;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Packaging;
use App\Models\PackagingManage;
use App\Models\OrderStatus;
use App\Models\SellerWithdrawVentor;
use App\Models\SmsGateway;
use App\Models\Video;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\BoostManage;
use App\Models\Boost;
use Carbon\Carbon;

class SellerController extends Controller
{
    function __construct()
    {
        $this->middleware('seller', ['except' => ['register', 'store', 'verify', 'resendotp', 'account_verify', 'login', 'signin', 'logout', 'forgot_password', 'forgot_verify', 'forgot_reset', 'forgot_store']]);
    }

    public function login()
    {
        return view('frontEnd.seller.login');
    }
    public function signin(Request $request)
    {
        $this->validate($request, [
            'phone'    => 'required',
            'password' => 'required|min:6'
        ]);
        $auth_check = Seller::where(['phone' => $request->phone,])->first();
        if ($auth_check) {
            // if ($auth_check->status != 'active') {
            //     Toastr::error('message', 'Your account inactive now please wait');
            //     return redirect()->back();
            // }
            if (Auth::guard('seller')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
                return redirect()->intended('seller/account');
                Toastr::success('You are login successfully', 'success!');
            }
            Toastr::error('message', 'Opps! your phone or password wrong');
            return redirect()->back();
        } else {
            Toastr::error('message', 'Sorry! You have no account');
            return redirect()->back();
        }
    }

    public function register()
    {
        return view('frontEnd.seller.register');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|unique:sellers',
            'phone'    => 'required|unique:sellers',
            'email'    => 'required|unique:sellers',
            'password' => 'required|min:6|same:confirm-password'
        ]);
        $last_id = Seller::orderBy('id', 'desc')->first();
        $last_id = $last_id ? $last_id->id + 1 : 1;
        $store              = new Seller();
        $store->name        = $request->name;
        $store->slug        = strtolower(Str::slug($request->name . '-' . $last_id));
        $store->phone       = $request->phone;
        $store->email       = $request->email;
        $store->password    = bcrypt($request->password);
        $store->verify      = rand(1111,9999);
        $store->status      = 'pending';
        $store->save();

        $site_setting = GeneralSetting::where('status', 1)->first();
        $sms_gateway = SmsGateway::where('status' , '1')->first();
        if ($sms_gateway) {
            $apiUrl = "https://quicksmsapp.com/Api/sms/campaign_api";
            $quickApi = "54ab22d2b79a3ee99438438319521c8d";
            $mobile =  $request->phone;
            $msg = "প্রিয়  $request->name!\r\nআপনার ওটিপি হল $store->verify\r\n$site_setting->name এর সাথে থাকার জন্য ধন্যবাদ ";
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$apiUrl?quick_api=$quickApi&mobile=$mobile&msg=" . urlencode($msg),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
        }


         Session::put('seller_verify',$request->phone);
        Toastr::success('Your account register successfully');
        return redirect()->route('seller.verify');
    }
    public function verify()
    {
        return view('frontEnd.seller.verify');
    }
    public function resendotp(Request $request)
    {
        $seller = Seller::where('phone', session::get('seller_verify'))->first();
        $seller->verify = rand(1111, 9999);
        $seller->save();

        $token = "105771848101705927690dd88320295e5924df7a86f71c5e85b9f";
        $message = "Dear $seller->name!\r\nYour account OTP is $seller->verify \r\nThank you for using baazarkori";

        $url = "http://api.greenweb.com.bd/api.php";
        $data = array(
            'to' => $seller->phone,
            'message' => "$message",
            'token' => "$token"
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);


        Toastr::success('Success', 'Resend code send successfully');
        return redirect()->back();
    }
    public function account_verify(Request $request)
    {
        $this->validate($request, [
            'otp' => 'required',
        ]);
        $seller = Seller::where('phone', session::get('seller_verify'))->first();
        if ($seller->verify != $request->otp) {
            Toastr::error('Success', 'Your OTP not match');
            return redirect()->back();
        }

        $seller->verify = 1;
        $seller->save();

        Session::forget('seller_verify');
        Auth::guard('seller')->loginUsingId($seller->id);
        return redirect()->route('seller.account');
    }
    public function forgot_password()
    {
        return view('frontEnd.seller.forgot_password');
    }
    public function forgot_verify(Request $request)
    {
        $seller = Seller::where('phone', $request->phone)->first();
        if (!$seller) {
            Toastr::error('Your phone number not found');
            return back();
        }
        $seller->verify = rand(1111, 9999);
        $seller->save();

        $token = "105771848101705927690dd88320295e5924df7a86f71c5e85b9f";
        $message = "Dear $seller->name!\r\nYour account forgot OTP is $seller->verify \r\nThank you for using hoichoibazar";

        $url = "http://api.greenweb.com.bd/api.php";
        $data = array(
            'to' => $request->phone,
            'message' => "$message",
            'token' => "$token"
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);


        session::put('seller_verify', $request->phone);
        Toastr::success('Your account register successfully');
        return redirect()->route('seller.forgot.reset');
    }
    public function forgot_reset()
    {
        if (!Session::get('seller_verify')) {
            Toastr::error('Something wrong please try again');
            return redirect()->route('seller.forgot.password');
        };
        return view('frontEnd.seller.forgot_reset');
    }
    public function forgot_store(Request $request)
    {

        $seller = Seller::where('phone', session::get('seller_verify'))->first();

        if ($seller->verify != $request->otp) {
            Toastr::error('Opps', 'Your OTP not match');
            return redirect()->back();
        }

        $seller->verify = 1;
        $seller->password = bcrypt($request->password);
        $seller->save();



        if ($seller->status = 'pending') {
            Toastr::error('Opps', 'Your account inactive no');
            return redirect()->back();
        }
        if (Auth::guard('seller')->attempt(['phone' => $seller->phone, 'password' => $request->password])) {
            Session::forget('seller_verify');
            Toastr::success('You are login successfully', 'success!');
            return redirect()->intended('seller/account');
        }
    }
    public function account()
    {
        $customer = Seller::with('seller_area')->find(Auth::guard('seller')->user()->id);

        $total_order = Order::where('seller_id', $customer->id)->count();
        $total_delivery = Order::where(['order_status' => '6', 'seller_id' => $customer->id])->count();
        $total_process = Order::where('seller_id', $customer->id)->whereNotIn('order_status', ['1', '6', '7', '8'])->count();
        $total_return = Order::where(['order_status' => '8', 'seller_id' => $customer->id])->count();
        $total_complete = Order::where(['order_status' => '6', 'seller_id' => $customer->id])->count();

        $total_purchase = OrderDetails::whereHas('order', function ($query) use ($customer) {
            $query->where(['order_status' => '6', 'seller_id' => $customer->id]);
        })->sum(DB::raw('purchase_price * qty'));

        $total_sales = OrderDetails::whereHas('order', function ($query) use ($customer) {
            $query->where(['order_status' => '6', 'seller_id' => $customer->id]);
        })->sum(DB::raw('sale_price * qty'));


        $total_amount = Order::where('seller_id', $customer->id)->sum('amount');
        $delivery_amount = Order::where(['order_status' => '6', 'seller_id' => $customer->id])->sum('amount');
        $process_amount = Order::where('seller_id', $customer->id)->whereNotIn('order_status', ['1', '6', '7', '8'])->sum('amount');
        $duesellerTotal = Sellerdeduct::where('seller_id', Auth::guard('seller')->user()->id)->sum('amount');
        // return $duesellerTotal;
        $return_amount = Order::where(['order_status' => '8', 'seller_id' => $customer->id])->sum('amount');

        // $total_earning = OrderDetails::whereHas('order', function ($query) use ($customer) {
        //     $query->where(['order_status' => '6', 'seller_id' => $customer->id]);
        // })->sum(DB::raw('(sale_price - purchase_price) * (1 - 0.15)'));



        $total_earning = Order::where(['order_status' => '6', 'seller_id' => $customer->id])
                      ->sum('seller_commission');
        //return $total_earning;

        //return $customer;

        // return OrderDetails::where('seller_id', Auth::guard('seller')->user()->id)->get();
        return view('frontEnd.seller.pages.account', compact('customer', 'total_order', 'total_delivery', 'total_process', 'total_return', 'total_complete', 'total_purchase', 'total_sales', 'total_amount', 'delivery_amount', 'process_amount', 'return_amount', 'total_earning','duesellerTotal'));
    }
    public function logout(Request $request)
    {
        Auth::guard('seller')->logout();
        Toastr::success('You are logout successfully', 'success!');
        return redirect()->route('seller.login');
    }
    public function orders(Request $request)
    {
        $order_status = OrderStatus::where('slug', $request->slug)->withCount('orders')->first();
        if ($request->slug == 'all') {
            $orders = Order::where('seller_id', Auth::guard('seller')->user()->id)->with('orderdetails', 'uddokta')->orderBy('created_at', 'DESC')->get();
            // return $orders;
        }else{
        $orders = Order::where('order_status', $order_status->id)->where('seller_id', Auth::guard('seller')->user()->id)->orderBy('created_at', 'DESC')->get();
        // return $orders;
        }
        return view('frontEnd.seller.pages.orders', compact('orders'));
    }


    public function withdraws()
    {
        $withdraws = SellerWithdrawVentor::where('seller_id', Auth::guard('seller')->user()->id)->with('withdraw_details')->get();
        //return $withdraws;
        return view('frontEnd.seller.pages.withdraws', compact('withdraws'));
    }

    public function sellerearn(){
        $customer = Seller::with('seller_area')->find(Auth::guard('seller')->user()->id);
        // $total_earning = OrderDetails::whereHas('order', function ($query) use ($customer) {
        //     $query->where(['order_status' => '6', 'seller_id' => $customer->id]);
        // })->sum(DB::raw('(sale_price - purchase_price) * (1 - 0.15)'));

        $sellerearn = Order::where(['order_status' => '6', 'seller_id' => $customer->id])->get();
        //return $sellerearn;

        return view('frontEnd.seller.pages.sellerearn', compact('sellerearn','customer'));
    }

    public function sellerexpense(){
         $dueseller = Sellerdeduct::where('seller_id',Auth::guard('seller')->user()->id)->get();
         //return $dueseller;
        return view('frontEnd.seller.pages.sellerexpense', compact('dueseller'));
    }

    public function invoice($id)
    {
        // return "ok";
        $order = Order::where('seller_id', Auth::guard('seller')->user()->id)->with('orderdetails', 'payment', 'shipping', 'customer')->find($id);
        // return $order;
        return view('frontEnd.seller.pages.invoice', compact('order'));
    }



    public function sellerwithdraw_request(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'receive' => 'required',
            'method' => 'required',
            'note' => 'required',
        ]);
        $pending_amount = SellerWithdrawVentor::where(['status' => 'pending', 'seller_id' => Auth::guard('seller')->user()->id])->sum('amount');
        // return $pending_amount;
        $balance_check = (Auth::guard('seller')->user()->balance - ($request->amount + $pending_amount));
        //return $balance_check;
        if (!Hash::check($request->password, Auth::guard('seller')->user()->password)) {
            Toastr::error('Your password is wrong', 'Failed');
            return redirect()->back();
        }
        if (Auth::guard('seller')->user()->balance < ($request->amount + $pending_amount)) {
            Toastr::error('Withdraw balance unsificient', 'Low Balance');
            return redirect()->back();
        }

        // Check if the user's balance is less than 200
        if ($balance_check < 300) {
            Toastr::error('Your balance must be at least 300 to make a withdrawal request.', 'Low Balance');
            return redirect()->back();
        }

        $withdraw = new SellerWithdrawVentor();
        $withdraw->seller_id = Auth::guard('seller')->user()->id;
        $withdraw->amount  = $request->amount;
        $withdraw->receive = $request->receive;
        $withdraw->method  = $request->method;
        $withdraw->note    = $request->note;
        $withdraw->request_date = Carbon::now();
        $withdraw->status = 'pending';
        //return $withdraw;
        $withdraw->save();

        Toastr::success('Withdraw request send successfully', 'success');
        return redirect()->back();
    }

    public function profile(Request $request)
    {
        $seller = Seller::where(['id' => Auth::guard('seller')->user()->id])->with('seller_area')->firstOrFail();
        return view('frontEnd.seller.pages.profile', compact('seller'));
    }
    public function profile_edit(Request $request)
    {
        $profile_edit = Seller::where(['id' => Auth::guard('seller')->user()->id])->firstOrFail();
        $districts = District::distinct()
            ->select('district')
            ->where('district', 'REGEXP', '^[a-zA-Z]')
            ->orderBy('district', 'asc')
            ->get();
        
        $areas = District::where(['district' => $profile_edit->district])
            ->select('area_name', 'id')
            ->get();
        // return $districts;
        // $districts = District::distinct()->select('district')->get();
        // $areas = District::where(['district' => $profile_edit->district])->select('area_name', 'id')->get();
        return view('frontEnd.seller.pages.profile_edit', compact('profile_edit', 'districts', 'areas'));
    }
    public function profile_update(Request $request)
    {
        // Fetch the current seller data
        $update_data = Seller::where(['id' => Auth::guard('seller')->user()->id])->firstOrFail();

        // Handle profile image upload
        $image = $request->file('image');
        if (is_array($image)) {
            $image = $image[0]; // Get the first file if it's an array
        }

        if ($image) {
            // Process profile image with Intervention
            $name = time() . '-' . $image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
            $name = strtolower(Str::slug($name));
            $uploadpath = 'public/uploads/seller/';
            $imageUrl = $uploadpath . $name;

            $img = Image::make($image->getRealPath());
            $img->encode('webp', 90);

            // Resize the image to 120x120
            $width = 120;
            $height = 120;
            $img->resize($width, $height);
            $img->save($imageUrl);
        } else {
            // Retain the current profile image if none uploaded
            $imageUrl = $update_data->image;
        }

        // Handle nid1 image upload (e.g., national ID card)
        $image2 = $request->file('nid1');
        if ($image2) {
            $name2 = time() . '-' . $image2->getClientOriginalName();
            $name2 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name2);
            $name2 = strtolower(preg_replace('/\s+/', '-', $name2));
            $uploadpath2 = 'public/uploads/settings/';
            $image2Url = $uploadpath2 . $name2;

            $img2 = Image::make($image2->getRealPath());
            $img2->encode('webp', 90);

            // Dynamic resizing for nid1
            $width2 = '';
            $height2 = '';
            $img2->height() > $img2->width() ? $width2 = null : $height2 = null;

            $img2->resize($width2, $height2);
            $img2->save($image2Url);
        }else{
            $image2Url = $update_data->nid1;
        }


        $image3 = $request->file('nid2');
        if ($image3) {
            $name3 = time() . '-' . $image3->getClientOriginalName();
            $name3 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name3);
            $name3 = strtolower(preg_replace('/\s+/', '-', $name3));
            $uploadpath2 = 'public/uploads/settings/';
            $image3Url = $uploadpath2 . $name3;

            $img3 = Image::make($image3->getRealPath());
            $img3->encode('webp', 90);

            $width3 = '';
            $height3 = '';
            $img3->height() > $img3->width() ? $width3 = null : $height3 = null;

            $img3->resize($width3, $height3);
            //return $img3;
            $img3->save($image3Url);
        }else{
            $image3Url = $update_data->nid2;
        }

        $update_data->owner_name = $request->owner_name;
        $update_data->name      = $request->name;
        $update_data->phone     = $request->phone;
        $update_data->email     = $request->email;
        $update_data->address   = $request->address;
        $update_data->nidnum    = $request->nidnum;
        $update_data->district  = $request->district;
        $update_data->area      = $request->area;
        $update_data->image     = $imageUrl;
        $update_data->nid1      = $image2Url;
        $update_data->nid2      = $image3Url;
        $update_data->save();

        // Flash success message and redirect
        Toastr::success('Your profile has been updated successfully', 'Success!');
        return redirect()->route('seller.profile');
    }

    public function change_pass()
    {
        return view('frontEnd.seller.pages.change_password');
    }
    public function password_update(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required_with:new_password|same:new_password|'
        ]);

        $customer = Seller::find(Auth::guard('seller')->user()->id);
        $hashPass = $customer->password;

        if (Hash::check($request->old_password, $hashPass)) {

            $customer->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            Toastr::success('Success', 'Password changed successfully!');
            return redirect()->route('seller.account');
        } else {
            Toastr::error('Failed', 'Old password not match!');
            return redirect()->back();
        }
    }
    public function process(Request $request)
    {
        $process = Order::find($request->hidden_id);
        $process->order_status = 2;
        $process->save();
        Toastr::success('Success','Data process successfully');
        return redirect()->back();
    }
    public function cancel(Request $request)
    {
        $cancel = Order::find($request->hidden_id);
        $cancel->order_status = 7;
        $cancel->save();
        Toastr::success('Success','Data cancel successfully');
        return redirect()->back();
    }

    public function packet(Request $request)
    {
        $orders = Packaging::where('seller_id', Auth::guard('seller')->user()->id)->get();
        //return $orders;
        return view('frontEnd.seller.pages.packet', compact('orders'));
    }

    public function packet_request(Request $request)
    {
        $districts = District::distinct()->select('district','shippingfee')->orderBy('district','asc')->get();
        $categories = PackagingManage::where('status',1)->select('id','package_name','amount')->get();
        //return $districts;

        return view('frontEnd.seller.pages.packet_request', compact('districts','categories'));
    }
    public function packet_store(Request $request)
    {
        
        $this->validate($request, [
            'shop_name' => 'required',
            'phone' => 'required',
            'district' => 'required',
            'area' => 'required',
        ]);

        $selectedCategory = PackagingManage::where('id', $request->category_id)
        ->where('status', 1)
        ->select('package_name', 'amount')
        ->first();

        $district = District::where('district', $request->district)
        ->select('shippingfee')
        ->first();

        $amount = $selectedCategory->amount + $district->shippingfee;


        $balance_check = (Auth::guard('seller')->user()->balance - ($amount));
        //return $balance_check;

        if (Auth::guard('seller')->user()->balance < $amount) {
            Toastr::error('Your balance unsificient', 'Low Balance');
            return redirect()->back();
        }

        // Check if the user's balance is less than 200
        if ($balance_check < 300) {
            Toastr::error('Your balance must be at least 300 to make a Order request.', 'Low Balance');
            return redirect()->back();
        }

        $seller = Seller::find(Auth::guard('seller')->user()->id);
        $seller->balance -= $amount;
        $seller->save();
        //return $seller;

         $transaction_data = Transaction::create([
            'user_id'     => $seller->id,
            'user_type'   => 'seller',
            'amount'      => $amount,
            'balance'     => $seller->balance,
            'amount_type' => 'debit', 
            'note'        => 'Packet Order',
            'status'      => 'complete',
        ]);

        $input = new Packaging();
        $input->seller_id   = Auth::guard('seller')->user()->id;
        $input->category_id = $request->category_id;
        $input->package_name= $selectedCategory->package_name;
        $input->amount      = $amount;
        $input->shop_name   = $request->shop_name;
        $input->phone       = $request->phone;
        $input->district    = $request->district;
        $input->area        = $request->area;
        $input->status      = 'processing';
        //return $input;
        $input->save();

        Toastr::success('Success','Data process successfully');
        return redirect()->back();
    }

    public function boost(Request $request)
    {
        $orders = Boost::where('user_id', Auth::guard('seller')->user()->id)->get();
        //return $orders;
        return view('frontEnd.seller.pages.boost', compact('orders'));
    }

    public function boost_request(Request $request)
    {   

        $categories = BoostManage::where('status',1)->select('id','boost_name','amount')->get();
        return view('frontEnd.seller.pages.boost_request', compact('categories'));
    }
    
    public function boost_store(Request $request)
    {
        $this->validate($request, [
            'day' => 'required',
            'type' => 'required',
            'amount' => 'required',
        ]);
        

        $boost_links = $request->boost_link;
        $boost_links_json = json_encode($boost_links);
        $boost_link_count = is_array($boost_links) ? count($boost_links) : 0;
      


        $site_setting = GeneralSetting::where('status', 1)->select('normal_rate','casual_rate')->first();
        
        if ($boost_link_count > 1) {
            $dollar = $site_setting->casual_rate;
        }else {
            $dollar = $site_setting->normal_rate;
        }

        $boosting_balance = $request->amount * $dollar;
        $balance_check = (Auth::guard('seller')->user()->balance - ($boosting_balance));
        //return $balance_check;

        if (Auth::guard('seller')->user()->balance < ($boosting_balance)) {
            Toastr::error('Your balance unsificient', 'Low Balance');
            return redirect()->back();
        }

        // Check if the user's balance is less than 200
        if ($balance_check < 300) {
            Toastr::error('Your balance must be at least 300 to make a Order request.', 'Low Balance');
            return redirect()->back();
        }

        $seller = Seller::find(Auth::guard('seller')->user()->id);
        $seller->balance -= $boosting_balance;
        $seller->save();

        $transaction_data = Transaction::create([
            'user_id'     => $seller->id,
            'user_type'   => 'seller',
            'amount'      => $boosting_balance,
            'balance'     => $seller->balance,
            'amount_type' => 'debit', 
            'note'        => 'Boosting Order',
            'status'      => 'complete',
        ]);
         

        $boosting = new Boost();
        $boosting->user_id       = Auth::guard('seller')->user()->id;
        $boosting->user_type     = 'seller';
        $boosting->type          = $request->type;
        $boosting->profile_access= $request->profile_access;
        $boosting->amount        = $boosting_balance;
        $boosting->dollar        = $request->amount;
        $boosting->dollar_rate   = $dollar;
        $boosting->day           = $request->day;
        $boosting->profile_access= $request->profile_access ?? '';
        $boosting->status        = 'processing';
        $boosting->boost_link    = $boost_links_json;
        $boosting->save();

        Toastr::success('Success','Data process successfully');
        return redirect()->back();


    }

    public function sellervideo(Request $request)
    {
        $video = Video::where('status', 1)->where('category_id','4')->get();
        //return $orders;
        return view('frontEnd.seller.pages.sellervideo', compact('video'));
    }




}
