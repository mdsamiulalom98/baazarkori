<?php

namespace App\Http\Controllers\Frontend;

use shurjopayv2\ShurjopayLaravelPackage8\Http\Controllers\ShurjopayController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\BoostManage;
use App\Models\District;
use App\Models\Boost;
use App\Models\Order;
use App\Models\ShippingCharge;
use App\Models\OrderDetails;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\Review;
use App\Models\PaymentGateway;
use App\Models\Video;
use App\Models\SmsGateway;
use App\Models\GeneralSetting;
use App\Models\Customerdeduct;
use App\Models\Customeraddamount;
use App\Models\SellerWithdraw;
use App\Models\RegistrationCharge;
use App\Models\Seller;
use App\Models\Wallet;
use App\Models\Transaction;
use Carbon\Carbon;


class CustomerController extends Controller
{
    function __construct()
    {
        $this->middleware('customer', ['except' => ['register', 'store', 'verify', 'resendotp', 'account_verify', 'login', 'signin', 'logout', 'checkout', 'forgot_password', 'forgot_verify', 'forgot_reset', 'forgot_store', 'forgot_resend', 'order_save', 'order_success', 'order_track', 'order_track_result', 'register_note']]);
    }

    public function review(Request $request)
    {
        $this->validate($request, [
            'ratting' => 'required',
            'review' => 'required',
        ]);

        // data save
        $review = new Review();
        $review->name = Auth::guard('customer')->user()->name ? Auth::guard('customer')->user()->name : 'N / A';
        $review->email = Auth::guard('customer')->user()->email ? Auth::guard('customer')->user()->email : 'N / A';
        $review->product_id = $request->product_id;
        $review->review = $request->review;
        $review->ratting = $request->ratting;
        $review->customer_id = Auth::guard('customer')->user()->id;
        $review->status = 'pending';
        $review->save();

        Toastr::success('Thanks, Your review send successfully', 'Success!');
        return redirect()->back();
    }

    public function login()
    {
        return view('frontEnd.layouts.customer.login');
    }

    public function signin(Request $request)
    {
        $auth_check = Customer::where(['phone' => $request->phone])->first();
        // return $auth_check;
        if ($auth_check) {
            if ($auth_check->status == 'pending') {
                    Toastr::error('Your account has been inactive, please contact to admin', 'Failed!');
                    return back();
                }
            if (Auth::guard('customer')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
                Toastr::success('You are login successfully', 'success!');
                if (Cart::instance('shopping')->count() > 0) {
                    return redirect()->route('customer.checkout');
                }
                return redirect()->intended('customer/dashboard');
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
        $video = Video::where('status', 1)->where('category_id','1')->get();
        return view('frontEnd.layouts.customer.register', compact('video'));
    }

    public function videouddokata()
    {
        $video = Video::where('status', 1)->where('category_id','2')->get();
        return view('frontEnd.layouts.customer.videouddokata', compact('video'));
    }

    public function videoreseller()
    {
        $video = Video::where('status', 1)->where('category_id','3')->get();
        return view('frontEnd.layouts.customer.videoreseller', compact('video'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'seller_type' => 'required',
            'phone' => 'required|unique:customers',
            'password' => 'required|min:6'
        ]);

        $last_id = Customer::max('id');
        $cust_id = $last_id ? 'C' . str_pad($last_id + 1, 5, '0', STR_PAD_LEFT) : 'C00001';

        if ($request->refferal_id) {
            // refer 1 check
            $reffer = Customer::select('id', 'name', 'refferal_id', 'is_affiliatar')->where(['refferal_id' => $request->refferal_id])->first();
            if (!$reffer) {
                Toastr::error('Failed Your refferal number not found');
                return redirect()->back();
            } elseif ($reffer->is_affiliatar != 1) {
                Toastr::error('Your refferal number is not a approved member');
                return redirect()->back();
            }
            $reffer_id = $reffer->id;
        } else {
            $reffer_id = NULL;
        }


        $currentDate = Carbon::now();
        $newDate = $currentDate->addMonth()->format('Y-m-d');

        $store = new Customer();
        $store->name = $request->name;
        $store->slug = strtolower(Str::slug($request->name . '-' . $cust_id));
        $store->phone = $request->phone;
        $store->seller_type = $request->seller_type;
        $store->seller_request = 0;
        $store->password = bcrypt($request->password);
        $store->refferal_id = rand(111111, 999999);
        $store->refferal_1 = $reffer_id;
        $store->is_affiliatar = 1;
        $store->verify = 1;
        $store->status = 'active';
        $store->cust_id = $cust_id;
        $store->activation = $newDate;
        $store->save();
        $customer = $store->id;
        Session::put('id', $customer);
        Toastr::success('Success', 'Account Create Successfully');
        // if($request->seller_type == 0){
        // }
        return redirect()->route('customer.login');
        // return redirect()->route('customer.register_note',['type'=>$request->seller_type]);


    }

   public function wallet_add(){
       $bkash_gateway = PaymentGateway::where(['status' => 1, 'type' => 'bkash'])->first();
       $shurjopay_gateway = PaymentGateway::where(['status' => 1, 'type' => 'shurjopay'])->first();
       $wallet = Wallet::select('id','phone','name','amount','status','payment_method','created_at')->where('customer_id',Auth::guard('customer')->user()->id)->get();
    //   return $wallet;
       return view('frontEnd.layouts.customer.wallet_add',compact('bkash_gateway','shurjopay_gateway','wallet'));
   }
    public function wallet_save(Request $request){
        $this->validate($request,[
            'amount'=>'required',
            'payment_method'=>'required',
        ]);

        $payment                 = new Wallet();
        $payment->customer_id    = Auth::guard('customer')->user()->id;
        $payment->name           = Auth::guard('customer')->user()->name ;
        $payment->email          = Auth::guard('customer')->user()->email ;
        $payment->phone          = Auth::guard('customer')->user()->phone;
        $payment->payment_method = $request->payment_method;
        $payment->sender_number  = $request->sender_number;
        $payment->transaction    = $request->transaction;
        $payment->amount         = $request->amount;
        $payment->wallets_type   = 'customer';
        $payment->status         = 'pending';
        //return $payment;
        $payment->save();
        // return redirect()->route('customer.wallet');

        Toastr::success('Success','Your payment successfully');
        return redirect()->back();

    }
    public function wallet(){
        // $wallet = Wallet::select('id','phone','name','amount','status','payment_method','created_at')->where('customer_id',Auth::guard('customer')->user()->id)->get();
        $wallet = Transaction::where('user_id', Auth::guard('customer')->user()->id)->get();
        // return $wallet;
        $addseller = Customeraddamount::where('customer_id',Auth::guard('customer')->user()->id)->get();
        // return $wallet;
       return view('frontEnd.layouts.customer.wallet',compact('wallet','addseller'));
   }

   public function order_cancel(Request $request)
    {
        $cancel = Order::find($request->hidden_id);
        $cancel->order_status = 7;
        $cancel->save();
        Toastr::success('Success','Data cancel successfully');
        return redirect()->back();
    }
    public function register_note()
    {
        $select_charge = ShippingCharge::where(['status' => 1, 'pos' => 1])->first();
        $bkash_gateway = PaymentGateway::where(['status' => 1, 'type' => 'bkash'])->first();
        $shurjopay_gateway = PaymentGateway::where(['status' => 1, 'type' => 'shurjopay'])->first();
        $charges = RegistrationCharge::where('status', 1)->get();
        Session::put('shipping', $select_charge->amount);
        return view('frontEnd.layouts.customer.register_note', compact('bkash_gateway', 'shurjopay_gateway', 'charges'));
    }
    public function verify()
    {
        return view('frontEnd.layouts.customer.verify');
    }
    public function resendotp(Request $request)
    {
        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();
        $customer_info->verify = rand(1111, 9999);
        $customer_info->save();
        $site_setting = GeneralSetting::where('status', 1)->first();
        $sms_gateway = SmsGateway::where('status', 1)->first();
        if ($sms_gateway) {
            $apiUrl = "https://quicksmsapp.com/Api/sms/campaign_api";
            $quickApi = "54ab22d2b79a3ee99438438319521c8d";
            $mobile =  $customer_info->phone;
            $msg = "Dear $customer_info->name!\r\nYour account verify OTP is $customer_info->verify \r\nThank you for using $site_setting->name";
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
        Toastr::success('Success', 'Resend code send successfully');
        return redirect()->back();
    }
    public function account_verify(Request $request)
    {
        $this->validate($request, [
            'otp' => 'required',
        ]);
        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();
        if ($customer_info->verify != $request->otp) {
            Toastr::error('Success', 'Your OTP not match');
            return redirect()->back();
        }

        $customer_info->verify = 1;
        $customer_info->status = 'active';
        $customer_info->save();
        Auth::guard('customer')->loginUsingId($customer_info->id);
        return redirect()->route('customer.account');
    }
    public function forgot_password()
    {
        return view('frontEnd.layouts.customer.forgot_password');
    }

    public function forgot_verify(Request $request)
    {
        $customer_info = Customer::where('phone', $request->phone)->first();
        if (!$customer_info) {
            Toastr::error('Your phone number not found');
            return back();
        }
        $customer_info->forgot = rand(1111, 9999);
        $customer_info->save();
        $site_setting = GeneralSetting::where('status', 1)->first();
        $sms_gateway = SmsGateway::where(['status' => 1, 'forget_pass' => 1])->first();
        if ($sms_gateway) {
            $apiUrl = "https://quicksmsapp.com/Api/sms/campaign_api";
            $quickApi = "54ab22d2b79a3ee99438438319521c8d";
            $mobile =  $customer_info->phone;
            $msg = "প্রিয়  $customer_info->name!\r\nআপনার পাসওয়ার্ড রিকোভার ওটিপি হল $customer_info->forgot\r\n$site_setting->name এর সাথে থাকার জন্য ধন্যবাদ ";
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

        session::put('verify_phone', $request->phone);
        Toastr::success('Your account register successfully');
        return redirect()->route('customer.forgot.reset');
    }

    public function forgot_resend(Request $request)
    {
        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();
        $customer_info->forgot = rand(1111, 9999);
        $customer_info->save();
        $site_setting = GeneralSetting::where('status', 1)->first();
        $sms_gateway = SmsGateway::where(['status' => 1])->first();
        if ($sms_gateway) {
            $apiUrl = "https://quicksmsapp.com/Api/sms/campaign_api";
            $quickApi = "54ab22d2b79a3ee99438438319521c8d";
            $mobile =  $customer_info->phone;
            $msg = "প্রিয়  $customer_info->name!\r\nআপনার পাসওয়ার্ড রিকোভার ওটিপি হল $customer_info->forgot\r\n$site_setting->name এর সাথে থাকার জন্য ধন্যবাদ ";
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

        Toastr::success('Success', 'Resend code send successfully');
        return redirect()->back();
    }
    public function forgot_reset()
    {
        if (!Session::get('verify_phone')) {
            Toastr::error('Something wrong please try again');
            return redirect()->route('customer.forgot.password');
        };
        return view('frontEnd.layouts.customer.forgot_reset');
    }
    public function forgot_store(Request $request)
    {

        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();

        if ($customer_info->forgot != $request->otp) {
            Toastr::error('Success', 'Your OTP not match');
            return redirect()->back();
        }

        $customer_info->forgot = 1;
        $customer_info->password = bcrypt($request->password);
        $customer_info->save();
        if (Auth::guard('customer')->attempt(['phone' => $customer_info->phone, 'password' => $request->password])) {
            Session::forget('verify_phone');
            Toastr::success('You are login successfully', 'success!');
            return redirect()->intended('customer/account');
        }
    }

    public function account()
    {
        return view('frontEnd.layouts.customer.account');
    }

    public function dashboard()
    {
        $userId = Auth::guard('customer')->user()->id;
        // $expense = Order::where(['reseller_id' => $userId, 'order_status' => 8])
        //     ->sum('shipping_charge');
        // $expenseDividedByTwo = $expense;

        // $customerInfo = Customer::find($userId);
        // $commissions = Order::where('reseller_id', $userId)->sum('commission');
        // $customerInfo->balance = $commissions - $expenseDividedByTwo;
        // $customerInfo->save();

        $orders = Order::where('customer_id', $userId)->orWhere('reseller_id', $userId)->where('order_status',6)->latest()->paginate(10);

        $totalOrderAmount = Order::where('customer_id', $userId)->orWhere('reseller_id', $userId)->sum('amount');

        $commissions = Order::where('reseller_id', $userId)->where('order_status',6)->latest()->paginate(10);
        $totalCommission = Order::where('reseller_id', $userId)->where('order_status', 6)->sum('commission');
        $withdraws = SellerWithdraw::where(['seller_id' => Auth::guard('customer')->user()->id])->latest()->paginate(20);

        return view('frontEnd.layouts.customer.dashboard', compact('orders', 'commissions', 'withdraws', 'totalCommission', 'totalOrderAmount', 'userId'));
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        Toastr::success('You are logout successfully', 'success!');
        return redirect()->route('customer.login');
    }

    public function request(Request $request)
    {
        $customer_info = Customer::find($request->hidden_id);
        $customer_info->seller_request = 1;
        $customer_info->save();

        Toastr::success('Your request successfully', 'success! Please wait for admin approval');
        return redirect()->route('customer.account');
    }

    public function checkout()
    {
        $bkash_gateway = PaymentGateway::where(['status' => 1, 'type' => 'bkash'])->first();
        $shurjopay_gateway = PaymentGateway::where(['status' => 1, 'type' => 'shurjopay'])->first();
        $districts = District::distinct()->select('district')->orderBy('district', 'asc')->get();
        Session::forget('advanced_pay');
        Session::put('shipping',0);
        return view('frontEnd.layouts.customer.checkout', compact('bkash_gateway', 'shurjopay_gateway', 'districts'));
    }

    public function order_save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'district' => 'required',
            'area' => 'required',
            'address' => 'required',
        ]);
        if (Cart::instance('shopping')->count() <= 0) {
            Toastr::error('Your shopping empty', 'Failed!');
            return redirect()->back();
        }

        $discount = Session::get('discount');

        if (count($this->seller_order()) > 1) {
            $shippingfee = Session::get('shipping') / count($this->seller_order());
        }else{
            $shippingfee = Session::get('shipping');
        }

        $shipping_area = District::where('id', $request->area)->first() ?? 'N/A';
        $exits_customer = Customer::where('phone', $request->phone)->select('phone', 'id')->first();
        if ($exits_customer) {
            $customer_id = $exits_customer->id;
        } else {
            $customer = Auth::guard('customer')->user();
            $reffer_id = $customer && $customer->seller_type == 1 ? $customer->id : 0;
            $last_id = Customer::max('id');
            $cust_id = $last_id ? 'C' . str_pad($last_id + 1, 5, '0', STR_PAD_LEFT) : 'C00001';
            $password = rand(111111, 999999);
            $store = new Customer();
            $store->name = $request->name;
            $store->slug = $request->name;
            $store->phone = $request->phone;
            $store->refferal_id = rand(111111, 999999);
            $store->refferal_1 = $reffer_id;
            $store->seller_type = 0;
            $store->password = bcrypt($password);
            $store->verify = 1;
            $store->status = 'pending';
            $store->cust_id = $cust_id;
            $store->save();
            $customer_id = $store->id;
        }

        // order data save

        // return $this->seller_order();
        foreach ($this->seller_order() as $seller_id) {

            $wholeselltotal = $reselltotal = $purchase_amount = $advancetotal = $subtotal = $refferal_commission = 0;
            $shopping = Cart::instance('shopping')->content();

            $carts = $shopping->filter(function($item) use ($seller_id) {
                return $item->options->seller_id == $seller_id;
            });

            foreach ($carts as $cart) {
                $purchase_amount += $cart->options->purchase_price * $cart->qty;
                $wholeselltotal += $cart->options->whole_sell_price * $cart->qty;
                $reselltotal += $cart->options->reseller_price * $cart->qty;
                $advancetotal += $cart->options->advance * $cart->qty;
                $subtotal += $cart->subtotal;
                $customer = Auth::guard('customer')->user();
                $wholesellprice = $cart->options->whole_sell_price;
                $product_qty = $cart->qty;
                if($customer->refferal_1) {
                    $reffer_customer = Customer::find($customer->refferal_1);
                    if ($reffer_customer) {
                        $refferal_commission += (($wholesellprice * $product_qty) / 100) * 2;
                    }
                }

                $seller = Seller::find($seller_id);
                $seller_total = $cart->price*$cart->qty;
                if ($seller) {
                    $site_setting = GeneralSetting::where('status', 1)->select('own_shipping','diff_shipping')->first();
                    if($seller->district == $request->district) {
                        $shippingfee = $site_setting->own_shipping;
                    } else {
                        $shippingfee = $site_setting->diff_shipping;
                    }

                    if($seller->commision_type == 'persentage') {
                        $commision = (($seller->commision * $seller_total) / 100);
                    } elseif($seller->commision_type == 'fixed') {
                        $commision = $seller->commision;
                    } else {
                        $commision = 0;
                    }
                } else {
                    $commision = 0;
                }
            }
            //return $commision;

            if (Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type != 0) {
                $subtotal = $reselltotal;
            } else {
                $subtotal = str_replace(',', '', $subtotal);
                $subtotal = str_replace('.00', '', $subtotal);
            }
            $order = new Order();
            $order->invoice_id = rand(11111, 99999);
            $order->amount = ($subtotal + $shippingfee) - $discount;
            $order->discount = $discount ?? 0;
            $order->shipping_charge = $shippingfee;
            $order->purchase_amount = $purchase_amount;
            $order->commission = Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type != 0 ? $reselltotal - $wholeselltotal : 0;
            $order->customer_id = $customer_id;
            $order->seller_id = $seller_id;
            $order->seller_commission = $commision ?? 0;
            $order->refferal_commission = $refferal_commission ?? 0;
            $order->reseller_id = Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type != 0 ? Auth::guard('customer')->user()->id : NULL;
            $order->order_status = 1;
            $order->advance = $advancetotal;
            $order->note = $request->note;
            //return $order;
            $order->save();

            // shipping data save
            $shipping = new Shipping();
            $shipping->order_id = $order->id;
            $shipping->customer_id = $customer_id;
            $shipping->name = $request->name;
            $shipping->phone = $request->phone;
            $shipping->address = $request->address;
            $shipping->district =   $request->district;
            $shipping->area      =   $request->area ? $shipping_area->area_name : 'Free Shipping';
            $shipping->save();

            // payment data save
            $payment = new Payment();
            $payment->order_id = $order->id;
            $payment->customer_id = $customer_id;
            $payment->payment_method = $request->payment_method;
            $payment->amount = $order->amount;
            $payment->trx_id = $request->transaction ?? '';
            $payment->sender_number = $request->sender_number ?? '';
            $payment->payment_status = 'pending';
            $payment->save();

            // order details data save

            foreach ($carts as $cart) {
                $seller = Seller::find($cart->options->seller_id);
                $seller_total = $cart->price*$cart->qty;
                if ($seller) {
                    if($seller->commision_type == 'persentage') {
                        $commision = (($seller->commision * $seller_total) / 100);
                    } elseif($seller->commision_type == 'fixed') {
                        $commision = $seller->commision;
                    } else {
                        $commision = 0;
                    }
                } else {
                    $commision = 0;
                }

                $order_details = new OrderDetails();
                $order_details->order_id = $order->id;
                $order_details->product_id = $cart->id;
                $order_details->product_name = $cart->name;
                $order_details->purchase_price = $cart->options->purchase_price;
                $order_details->reseller_price = $cart->options->whole_sell_price;
                $order_details->product_color = $cart->options->product_color;
                $order_details->product_size = $cart->options->product_size;
                $order_details->sale_price = Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type != 0 ? $cart->options->reseller_price : $cart->price;
                $order_details->commission = Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type != 0 ? $cart->options->reseller_price - $cart->options->whole_sell_price : 0;
                $order_details->qty = $cart->qty;
                $order_details->seller_id        =   $cart->options->seller_id ?? 1;
                $order_details->seller_commision =   $commision;
                $order_details->save();
            }
        }

        Cart::instance('shopping')->destroy();

        Toastr::success('Thanks, Your order place successfully', 'Success!');
        $site_setting = GeneralSetting::where('status', 1)->first();
        $sms_gateway = SmsGateway::where(['status' => 1, 'order' => '1'])->first();
        if ($sms_gateway) {
            $apiUrl = "https://quicksmsapp.com/Api/sms/campaign_api";
            $quickApi = "54ab22d2b79a3ee99438438319521c8d";
            $mobile =  $request->phone;
            $msg = "প্রিয়  $request->name!\r\nআপনার অর্ডারটি [$order->invoice_id] আমাদের কাছে পৌঁছেছে ,অতি দ্রুত আপনার অর্ডারটি কনফার্ম করা হবে $site_setting->name এর সাথে থাকার জন্য ধন্যবাদ ";
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

        if ($request->payment_method == 'bkash') {
            return redirect('/bkash/checkout-url/create?order_id=' . $order->id);
        } elseif ($request->payment_method == 'shurjopay') {
            $info = array(
                'currency' => "BDT",
                'amount' => $order->amount,
                'order_id' => uniqid(),
                'discsount_amount' => 0,
                'disc_percent' => 0,
                'client_ip' => $request->ip(),
                'customer_name' => $request->name,
                'customer_phone' => $request->phone,
                'email' => "customer@gmail.com",
                'customer_address' => $request->address,
                'customer_city' => $request->area,
                'customer_state' => $request->area,
                'customer_postcode' => "1212",
                'customer_country' => "BD",
                'value1' => $order->id
            );
            $shurjopay_service = new ShurjopayController();
            return $shurjopay_service->checkout($info);
        } else {
            return redirect('customer/order-success/' . $order->id);
        }
    }

    public function orders()
    {
        $userId = Auth::guard('customer')->user()->id;

        $orders = Order::where('customer_id', $userId)->orWhere('reseller_id', $userId)->with('status')->latest()->paginate(10);
        // return $orders;

        $totalOrderAmount = Order::where('customer_id', $userId)->orWhere('reseller_id', $userId)->sum('amount');

        return view('frontEnd.layouts.customer.orders', compact('orders', 'totalOrderAmount'));
    }
    public function order_success($id)
    {
        $order = Order::where('id', $id)->firstOrFail();
        return view('frontEnd.layouts.customer.order_success', compact('order'));
    }
    public function invoice(Request $request)
    {
        $order = Order::where(['id' => $request->id])->with('orderdetails', 'payment', 'shipping', 'customer')->firstOrFail();
        return view('frontEnd.layouts.customer.invoice', compact('order'));
    }
    public function order_note(Request $request)
    {
        $order = Order::where(['id' => $request->id, 'customer_id' => Auth::guard('customer')->user()->id])->firstOrFail();
        return view('frontEnd.layouts.customer.order_note', compact('order'));
    }
    public function profile_edit(Request $request)
    {
        $profile_edit = Customer::where(['id' => Auth::guard('customer')->user()->id])->firstOrFail();
        $districts = District::distinct()->select('district')->get();
        $areas = District::where(['district' => $profile_edit->district])->select('area_name', 'id')->get();
        return view('frontEnd.layouts.customer.profile_edit', compact('profile_edit', 'districts', 'areas'));
    }
    public function profile_update(Request $request)
    {
        $update_data = Customer::where(['id' => Auth::guard('customer')->user()->id])->firstOrFail();

        $image = $request->file('image');
        if ($image) {
            // image with intervention
            $name = time() . '-' . $image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
            $name = strtolower(Str::slug($name));
            $uploadpath = 'public/uploads/customer/';
            $imageUrl = $uploadpath . $name;
            $img = Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = 120;
            $height = 120;
            $img->resize($width, $height);
            $img->save($imageUrl);
        } else {
            $imageUrl = $update_data->image;
        }

        $update_data->name = $request->name;
        $update_data->phone = $request->phone;
        $update_data->email = $request->email;
        $update_data->address = $request->address;
        $update_data->district = $request->district;
        $update_data->area = $request->area;
        $update_data->image = $imageUrl;
        $update_data->save();

        Toastr::success('Your profile update successfully', 'Success!');
        return redirect()->route('customer.account');
    }

    public function wishlist()
    {
        $data = Cart::instance('wishlist')->content();
        return view('frontEnd.layouts.customer.wishlist', compact('data'));
    }

    public function order_track()
    {
        return view('frontEnd.layouts.customer.order_track');
    }

    public function order_track_result(Request $request)
    {

        $phone = $request->phone;
        $invoice_id = $request->invoice_id;

        if ($phone != null && $invoice_id == null) {
            $order = DB::table('orders')
                ->join('shippings', 'orders.id', '=', 'shippings.order_id')
                ->where(['shippings.phone' => $request->phone])
                ->first();
            $orderdetails = OrderDetails::where('order_id', $order->id)->get();
        } else if ($invoice_id && $phone) {
            $order = DB::table('orders')
                ->join('shippings', 'orders.id', '=', 'shippings.order_id')
                ->where(['orders.invoice_id' => $request->invoice_id, 'shippings.phone' => $request->phone])
                ->first();
            $orderdetails = OrderDetails::where('order_id', $order->id)->get();
        }

        if (!$order) {

            Toastr::error('message', 'Something Went Wrong !');
            return redirect()->back();
        }

        //   return $order->count();

        return view('frontEnd.layouts.customer.tracking_result', compact('order', 'orderdetails'));
    }


    public function change_pass()
    {
        return view('frontEnd.layouts.customer.change_password');
    }

    public function password_update(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required_with:new_password|same:new_password|'
        ]);

        $customer = Customer::find(Auth::guard('customer')->user()->id);
        $hashPass = $customer->password;

        if (Hash::check($request->old_password, $hashPass)) {

            $customer->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            Toastr::success('Success', 'Password changed successfully!');
            return redirect()->route('customer.account');
        } else {
            Toastr::error('Failed', 'Old password not match!');
            return redirect()->back();
        }
    }


    public function commissions()
    {
        $userId = Auth::guard('customer')->user()->id;
        $commissions = Order::where(['reseller_id'=>$userId,'order_status'=>6])->latest()->paginate(10);
        $totalCommission = Order::where(['reseller_id'=>$userId,'order_status'=>6])->sum('commission');

        return view('frontEnd.layouts.customer.commissions', compact('commissions', 'totalCommission'));
    }


    public function expense()
    {
        $userId = Auth::guard('customer')->user()->id;
        $expense = Order::where(['reseller_id' => $userId, 'order_status' => 8])->with('status')->latest()->paginate(10);

        $dueseller = Customerdeduct::where('customer_id',Auth::guard('customer')->user()->id)->get();
        // $totalexpense = Order::where('reseller_id', $userId)->sum('expense');

        return view('frontEnd.layouts.customer.expense', compact('expense','dueseller'));
    }


    public function withdraw()
    {

        $withdraws = SellerWithdraw::where(['seller_id' => Auth::guard('customer')->user()->id])->latest()->paginate(20);
        return view('frontEnd.layouts.customer.withdraw', compact('withdraws'));
    }

    public function withdraw_request(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'receive' => 'required',
            'method' => 'required',
            'note' => 'required',
        ]);
        $pending_amount = SellerWithdraw::where(['status' => 'pending', 'seller_id' => Auth::guard('customer')->user()->id])->sum('amount');
        $balance_check = (Auth::guard('customer')->user()->balance - ($request->amount + $pending_amount));

        if (!Hash::check($request->password, Auth::guard('customer')->user()->password)) {
            Toastr::error('Your password is wrong', 'Failed');
            return redirect()->back();
        }
        if (Auth::guard('customer')->user()->balance < ($request->amount + $pending_amount)) {
            Toastr::error('Withdraw balance unsificient', 'Low Balance');
            return redirect()->back();
        }

        // Check if the user's balance is less than 200
        if ($balance_check < 200) {
            Toastr::error('Your balance must be at least 200 to make a withdrawal request.', 'Low Balance');
            return redirect()->back();
        }

        $withdraw = new SellerWithdraw();
        $withdraw->seller_id = Auth::guard('customer')->user()->id;
        $withdraw->amount  = $request->amount;
        $withdraw->receive = $request->receive;
        $withdraw->method  = $request->method;
        $withdraw->note    = $request->note;
        $withdraw->request_date = Carbon::now();
        $withdraw->status = 'pending';
        $withdraw->save();

        Toastr::success('Withdraw request send successfully', 'success');
        return redirect()->back();
    }
    public function seller_order(){
        $cartItems = Cart::instance('shopping')->content();
        $seller_orders = [];
        foreach ($cartItems as $item) {
            $sellerId = $item->options->seller_id;
            if (!in_array($sellerId, $seller_orders)) {
                $seller_orders[] = $sellerId;
            }
        }
        return $seller_orders;
    }

    public function seller_ordercount(){
        $cartItems = Cart::instance('shopping')->content();
        $seller_orders = [];
        foreach ($cartItems as $item) {
            $sellerId = $item->options->seller_id;
            if (!in_array($sellerId, $seller_orders)) {
                $seller_orders[] = $sellerId;
            }
        }
        return count($seller_orders);
    }

    public function boostc(Request $request)
    {
        $orders = Boost::where('user_id', Auth::guard('customer')->user()->id)->get();
        //return $orders;
        return view('frontEnd.layouts.customer.boostc', compact('orders'));
    }

    public function boostc_request(Request $request)
    {
        $categories = BoostManage::where('status', 1)
            ->select('id', 'boost_name', 'amount')
            ->get();

        $site_setting = GeneralSetting::where('status', 1)
            ->select('normal_rate', 'casual_rate')
            ->first();

        $casual_dollar = $site_setting->casual_rate;
        $normal_dollar = $site_setting->normal_rate;

        return view('frontEnd.layouts.customer.boostc_request', compact('categories', 'casual_dollar', 'normal_dollar'));
    }

    public function boostc_store(Request $request)
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
        $balance_check = (Auth::guard('customer')->user()->balance - ($boosting_balance));
        //return $balance_check;

        if (Auth::guard('customer')->user()->balance < ($boosting_balance)) {
            Toastr::error('Your balance unsificient', 'Low Balance');
            return redirect()->back();
        }

        // Check if the user's balance is less than 200
        if ($balance_check < 300) {
            Toastr::error('Your balance must be at least 300 to make a Order request.', 'Low Balance');
            return redirect()->back();
        }

        $seller = Customer::find(Auth::guard('customer')->user()->id);
        $seller->balance -= $boosting_balance;
        $seller->save();

        $transaction_data = Transaction::create([
            'user_id'     => $seller->id,
            'user_type'   => 'customer',
            'amount'      => $boosting_balance,
            'balance'     => $seller->balance,
            'amount_type' => 'debit',
            'note'        => 'boosting order',
            'status'      => 'complete',
        ]);


        $boosting = new Boost();
        $boosting->user_id       = Auth::guard('customer')->user()->id;
        $boosting->user_type     = 'customer';
        $boosting->type          = $request->type;
        $boosting->profile_access= $request->profile_access;
        $boosting->amount        = $boosting_balance;
        $boosting->dollar        = $request->amount;
        $boosting->dollar_rate   = $dollar;
        $boosting->day           = $request->day;
        $boosting->profile_access= $request->profile_access ?? '';
        $boosting->status        = 'processing';
        $boosting->boost_link    = $boost_links_json;
        // return $boosting;
         $boosting->save();

        Toastr::success('Success','Data process successfully');
        return redirect()->back();


    }


}


