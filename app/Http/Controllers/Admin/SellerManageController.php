<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\OrderDetails;
use App\Models\District;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Sellerdeduct;
use App\Models\Selleraddamount;
use App\Models\Transaction;
use App\Models\SellerWithdraw;
use App\Models\SellerWithdrawDetails;
use Toastr;
use Image;
use File;
use Hash;
use Auth;

class SellerManageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:seller-list', ['only' => ['index']]);
        $this->middleware('permission:seller-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:seller-profile', ['only' => ['profile']]);
        $this->middleware('permission:seller-products', ['only' => ['products']]);
        $this->middleware('permission:seller-pending-products', ['only' => ['pending_product']]);
        $this->middleware('permission:seller-product-approval', ['only' => ['product_approve']]);
        $this->middleware('permission:seller-withdraw', ['only' => ['withdraw']]);
        $this->middleware('permission:seller-login', ['only' => ['adminlog']]);
    }
    public function index(Request $request)
    {
        $show_data = Seller::where(['status' => $request->status])->get();
        return view('backEnd.seller.index', compact('show_data'));
    }

    public function edit($id)
    {
        $edit_data = Seller::find($id);
        $districts = District::distinct()
            ->select('district')
            ->get();
        $areas = District::where(['district' => $edit_data->district])
            ->select('area_name', 'id')
            ->get();
        return view('backEnd.seller.edit', compact('edit_data', 'districts', 'areas'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        // new password
        $input = $request->except('hidden_id');
        $update_data = Seller::find($request->hidden_id);
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }
        // new image
        $image = $request->file('image');
        if ($image) {
            // image with intervention
            $name = time() . '-' . $image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/customer/';
            $imageUrl = $uploadpath . $name;
            $img = Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = 100;
            $height = 100;
            $img->height() > $img->width() ? ($width = null) : ($height = null);
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($imageUrl);
            $input['image'] = $imageUrl;
            File::delete($update_data->image);
        } else {
            $input['image'] = $update_data->image;
        }
        $input['status'] = $request->status ? $request->status : 'inactive';
        $update_data->update($input);

        Toastr::success('Success', 'Data update successfully');
        // return redirect()->back();
        return redirect('admin/seller/manage?status=pending');

    }

    public function inactive(Request $request)
    {
        $inactive = Seller::find($request->hidden_id);
        $inactive->status = 'inactive';
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Seller::find($request->hidden_id);
        $active->status = 'active';
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        return redirect()->back();
    }
    

    public function profile(Request $request)
    {
        $profile = Seller::with('orders', 'withdraws', 'deducts','seller_area','addamount')->find($request->id);
        //return $profile;
        return view('backEnd.seller.profile', compact('profile'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'note' => 'required',
        ]);
        $input = $request->all();
        $seller = Seller::find($request->seller_id);
        $seller->balance -= $request->amount;
        $seller->save();

        $input['amount'] = $request->amount;
        $input['note']   = $request->note;
        $input['status'] = 'active';
        //return $input;
        Sellerdeduct::create($input);

        $transaction_data = Transaction::create([
            'user_id'     => $seller->id,
            'user_type'   => 'seller',
            'amount'      => $request->amount,
            'balance'     => $seller->balance,
            'amount_type' => 'debit', 
            'note'        => 'Admin Amount (-)',
            'status'      => 'complete',
        ]);


        Toastr::success('Success','Data insert successfully');
        return redirect()->back();
    }

    public function addstore(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'note' => 'required',
        ]);
        $input = $request->all();
        $seller = Seller::find($request->seller_id);
        $seller->balance += $request->amount;
        //return $seller;
         $seller->save();

        $input['amount'] = $request->amount;
        $input['note'] = $request->note;
        $input['status'] = 'active';

        Selleraddamount::create($input);

        $transaction_data = Transaction::create([
            'user_id'     => $seller->id,
            'user_type'   => 'seller',
            'amount'      => $request->amount,
            'balance'     => $seller->balance,
            'amount_type' => 'credit', 
            'note'        => 'Admin add amount',
            'status'      => 'complete',
        ]);


        Toastr::success('Success','data insert successfully');
        return redirect()->back();
    }

    public function change(Request $request)
    {
        $sellerId = Auth::guard('seller')->user()->id;

        $change = Sellerdeduct::where('seller_id', $sellerId)
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
    


    public function withdraw(Request $request)
    {
        $data = OrderDetails::where(['seller_id' => $request->id])
            ->whereHas('order', function ($query) {
                $query->where(['order_status' => 'delivered', 'pay_status' => 0]);
            })
            ->get();
        $seller = Seller::select('id', 'name', 'status')->find($request->id);
        //return $data;   
        return view('backEnd.seller.withdraw', compact('data', 'seller'));
    }
    public function withdraw_save(Request $request)
    {
        $amount = OrderDetails::whereIn('id', $request->order_id)->sum(\DB::raw('(qty*sale_price) - (seller_commision)'));
        $withdraw = new SellerWithdraw();
        $withdraw->seller_id = $request->seller_id;
        $withdraw->amount = $amount;
        $withdraw->status = $request->withdraw_status;
        $withdraw->save();

        $orderdetails = OrderDetails::whereIn('id', $request->order_id)->get();
        foreach ($orderdetails as $key => $orderdetail) {
            $details = new SellerWithdrawDetails();
            $details->withdraw_id = $withdraw->id;
            $details->seller_id = $request->seller_id;
            $details->order_id = $orderdetail->order_id;
            $details->order_details_id = $orderdetail->id;
            $details->product_id = $orderdetail->product_id;
            $details->amount = $orderdetail->sale_price * $orderdetail->qty;
            $details->status = $request->withdraw_status;
            $details->save();

            $details_update = OrderDetails::find($orderdetail->id);
            $details_update->pay_status = 1;
            $details_update->save();
        }

        $seller = Seller::find($request->seller_id);
        $seller->balance -= $amount;
        $seller->withdraw += $amount;
        $seller->save();


        Toastr::success('Success', 'Payment withdraw successfully');
        return redirect()->back();
    }
    //
    public function products(Request $request)
    {
        $data = Product::where(['seller_id' => $request->id])->get();
        $seller = Seller::select('id', 'name', 'status')->find($request->id);
        return view('backEnd.seller.products', compact('data', 'seller'));
    }
    public function adminlog(Request $request)
    {
        $seller = Seller::find($request->hidden_id);
        Auth::guard('seller')->loginUsingId($seller->id);
        return redirect()->route('seller.account');
    }
    public function pending_product(Request $request)
    {
        $data = Product::where(['approval' => 0])->get();
        return view('backEnd.seller.pending_product', compact('data'));
    }

    public function product_approve(Request $request)
    {
        $product = Product::find($request->hidden_id);
        $product->status = 1;
        $product->approval = 1;
        $product->save();
        Toastr::success('Success', 'Product approve successfully');
        return redirect()->back();
    }

    public function procode_edit($id)
    {
        $edit_data = Product::with('images')->find($id);
        return view('backEnd.seller.procode_edit', compact('edit_data'));
    }

    public function procode_update(Request $request)
    {
        $update_data = Product::find($request->id);
        $update_data->product_code = $request->product_code;
        $update_data->proCommission = $request->proCommission;
        $update_data->status = 1;
        $update_data->approval = 1;
        $update_data->save();

        return redirect()->route('sellers.pending_product');
    }
}
