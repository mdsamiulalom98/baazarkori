<?php

namespace App\Http\Controllers\Frontend;

use shurjopayv2\ShurjopayLaravelPackage8\Http\Controllers\ShurjopayController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Product;
use App\Models\District;
use App\Models\CreatePage;
use App\Models\Campaign;
use App\Models\Banner;
use App\Models\ShippingCharge;
use App\Models\PaymentGateway;
use App\Models\Productcolor;
use App\Models\Productsize;
use App\Models\OrderDetails;
use App\Models\Payment;
use App\Models\Slider;
use App\Models\OurService;
use App\Models\Order;
use App\Models\Brand;
use App\Models\Review;
use App\Models\Seller;
use App\Models\Transaction;
use App\Models\SpecialOffer;
use App\Models\WholesellCustomer;
use App\Models\RegistrationCharge;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $frontcategory = Category::where(['status' => 1])
            ->select('id', 'name', 'image', 'slug', 'status', 'sort')
            ->orderBy('sort', 'ASC')
            ->get();

        $sliders = Slider::where('status', 1)->get();

        $sliderbottomads = Banner::where(['status' => 1, 'category_id' => 5])
            ->select('id', 'image', 'link', 'title')
            ->limit(4)
            ->get();

        $featureads = Banner::where(['status' => 1, 'category_id' => 11])
            ->select('id', 'image', 'link')
            ->latest()
            ->limit(3)
            ->get();

        $backgroundimg = Banner::where(['status' => 1, 'category_id' => 9])
            ->select('id', 'image')
            ->first();

        $popup_banner = Banner::where(['status' => 1, 'category_id' => 10])
        ->select('id', 'image','link')
        ->get();


        $hotdeal_top = Product::where(['status' => 1, 'topsale' => 1, 'approval'=>1])
            ->orderBy('id', 'DESC')
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'whole_sell_price', 'stock', 'specification', 'sold')
            ->with('prosizes', 'procolors', 'reviews')
            ->limit(8)
            ->get();
        // return $hotdeal_top;

        $toprated = Product::where(['status' => 1, 'toprated' => 1, 'approval'=>1])
            ->orderBy('id', 'DESC')
            ->select('id', 'name', 'slug', 'new_price', 'whole_sell_price', 'old_price', 'stock', 'specification', 'sold')
            ->with('prosizes', 'procolors', 'reviews')
            ->limit(8)
            ->get();

        $on_sale = Product::where(['status' => 1, 'on_sale' => 1, 'approval'=>1])
            ->orderBy('id', 'DESC')
            ->select('id', 'name', 'slug', 'new_price', 'whole_sell_price', 'old_price', 'stock', 'specification', 'sold')
            ->with('prosizes', 'procolors', 'reviews')
            ->latest()
            ->get();
        // return $on_sale;
        $on_sale_tab = Product::where(['status' => 1, 'on_sale' => 1, 'approval'=>1])
            ->orderBy('id', 'DESC')
            ->select('id', 'name', 'slug', 'new_price', 'whole_sell_price', 'old_price', 'stock', 'specification', 'sold')
            ->with('prosizes', 'procolors', 'reviews')
            ->limit(8)
            ->latest()
            ->get();


        $baazarkorimall = Product::where(['status' => 1, 'seller_id' => 1, 'approval'=>1])
            ->orderBy('id', 'DESC')
            ->select('id', 'name', 'slug', 'new_price', 'whole_sell_price', 'old_price', 'stock', 'specification', 'sold')
            ->with('prosizes', 'procolors', 'reviews')
            ->latest()
            ->get();
        //return $baazarkorimall;



        $best_deals = Product::where(['status' => 1, 'best_deals' => 1, 'approval'=>1])
            ->orderBy('id', 'DESC')
            ->select('id', 'name', 'slug', 'new_price', 'whole_sell_price', 'old_price', 'stock', 'specification', 'sold')
            ->with('prosizes', 'procolors', 'reviews')
            ->limit(9)
            ->latest()
            ->get();

        $special_offer = SpecialOffer::where(['status' => 1])
            ->where('date', '>', Carbon::today())
            ->orderBy('id', 'DESC')
            ->with('product', 'product.prosizes', 'product.procolors', 'product.reviews')
            ->latest()
            ->get();


        $feature_product = Product::where(['status' => 1, 'feature_product' => 1, 'approval'=>1])
            ->orderBy('id', 'DESC')
            ->select('id', 'name', 'slug', 'new_price', 'whole_sell_price', 'old_price', 'stock', 'sold', 'specification')
            ->with('prosizes', 'procolors', 'reviews')
            ->limit(8)
            ->get();

        $hotdeal_bottom = Product::where(['status' => 1, 'topsale' => 1, 'approval'=>1])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'whole_sell_price', 'stock', 'specification', 'sold')
            ->skip(12)
            ->limit(12)
            ->get();

        $homeproducts = Category::where(['front_view' => 1, 'status' => 1,])
            ->orderBy('id', 'ASC')
            ->with(['products', 'products.image'])
            ->get()
            ->map(function ($query) {
                $query->setRelation('products', $query->products->take(12));
                return $query;
            });
        // return $homeproducts;
        if($request->r){
            Session::put('refferal_id',$request->r);
            return redirect()->route('customer.register');
        }
        return view('frontEnd.layouts.pages.index', compact('sliders', 'frontcategory', 'hotdeal_top', 'hotdeal_bottom', 'backgroundimg', 'homeproducts', 'sliderbottomads', 'featureads', 'toprated', 'on_sale', 'feature_product', 'on_sale_tab', 'best_deals', 'special_offer','popup_banner','baazarkorimall'));
    }

    public function hotdeals()
    {

        $products = Product::where(['status' => 1, 'approval'=>1])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'whole_sell_price')
            ->orderBy('created_at', 'desc')
            ->paginate(36);
        return view('frontEnd.layouts.pages.hotdeals', compact('products'));
    }

    public function feature_product()
    {

        $feature_product = Product::where(['status' => 1, 'feature_product' => 1, 'approval'=>1])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'whole_sell_price')
            ->paginate(36);

        return view('frontEnd.layouts.pages.featureproduct', compact('feature_product'));
    }

    public function on_sale()
    {

        $on_sale = Product::where(['status' => 1, 'on_sale' => 1, 'approval'=>1])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'whole_sell_price')
            ->paginate(36);

        return view('frontEnd.layouts.pages.onsale', compact('on_sale'));
    }

    public function baazarkorimall()
    {

        $baazarkorimall = Product::where(['status' => 1, 'seller_id' => 1, 'approval'=>1])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'whole_sell_price')
            ->paginate(36);

        return view('frontEnd.layouts.pages.baazarkorimall', compact('baazarkorimall'));
    }

    public function toprated()
    {

        $toprated = Product::where(['status' => 1, 'toprated' => 1, 'approval'=>1])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'whole_sell_price')
            ->paginate(36);

        return view('frontEnd.layouts.pages.toprated', compact('toprated'));
    } 


    public function yourshop($slug, $id)
    {
        $seller = Seller::where(['slug' => $slug])->first();
        $yourshop = Product::where(['seller_id' => $id, 'status' => 1,])
            ->select('id', 'name', 'slug','seller_id', 'new_price', 'old_price')
            ->paginate(36);
        // return $yourshop;

        return view('frontEnd.layouts.pages.yourshop', compact('seller','yourshop'));
    }
    
    public function sellershop($slug, $id)
    {
        $seller = Seller::where(['slug' => $slug])->first();
        $yourshop = Product::where(['seller_id' => $id, 'status' => 1,])
            ->select('id', 'name', 'slug','seller_id', 'new_price', 'old_price')
            ->paginate(36);
        // return $yourshop;

        return view('frontEnd.layouts.pages.sellershop', compact('seller','yourshop'));
    }

    public function category($slug, Request $request)
    {
        $category = Category::where(['slug' => $slug, 'status' => 1])->first();
        $products = Product::where(['status' => 1, 'approval'=>1, 'category_id' => $category->id])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'whole_sell_price', 'category_id', 'stock', 'specification');
        $subcategories = Subcategory::where('category_id', $category->id)->get();

        // return $request->sort;
        if ($request->sort == 1) {
            $products = $products->orderBy('created_at', 'desc');
        } elseif ($request->sort == 2) {
            $products = $products->orderBy('created_at', 'asc');
        } elseif ($request->sort == 3) {
            $products = $products->orderBy('new_price', 'desc');
        } elseif ($request->sort == 4) {
            $products = $products->orderBy('new_price', 'asc');
        } elseif ($request->sort == 5) {
            $products = $products->orderBy('name', 'asc');
        } elseif ($request->sort == 6) {
            $products = $products->orderBy('name', 'desc');
        } else {
            $products = $products->latest();
        }

        $min_price = $products->min('new_price');
        $max_price = $products->max('new_price');
        if ($request->min_price && $request->max_price) {
            $products = $products->where('new_price', '>=', $request->min_price);
            $products = $products->where('new_price', '<=', $request->max_price);
        }

        $selectedSubcategories = $request->input('subcategory', []);
        $products = $products->when($selectedSubcategories, function ($query) use ($selectedSubcategories) {
            return $query->whereHas('subcategory', function ($subQuery) use ($selectedSubcategories) {
                $subQuery->whereIn('id', $selectedSubcategories);
            });
        });

        $products = $products->paginate(24);
        return view('frontEnd.layouts.pages.category', compact('category', 'products', 'subcategories', 'min_price', 'max_price'));
    }

    public function subcategory($slug, Request $request)
    {
        $subcategory = Subcategory::where(['slug' => $slug, 'status' => 1])->first();
        $products = Product::where(['status' => 1, 'approval'=>1, 'subcategory_id' => $subcategory->id])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'whole_sell_price', 'category_id', 'subcategory_id', 'stock', 'specification');
        $childcategories = Childcategory::where('subcategory_id', $subcategory->id)->get();

        // return $request->sort;
        if ($request->sort == 1) {
            $products = $products->orderBy('created_at', 'desc');
        } elseif ($request->sort == 2) {
            $products = $products->orderBy('created_at', 'asc');
        } elseif ($request->sort == 3) {
            $products = $products->orderBy('new_price', 'desc');
        } elseif ($request->sort == 4) {
            $products = $products->orderBy('new_price', 'asc');
        } elseif ($request->sort == 5) {
            $products = $products->orderBy('name', 'asc');
        } elseif ($request->sort == 6) {
            $products = $products->orderBy('name', 'desc');
        } else {
            $products = $products->latest();
        }

        $min_price = $products->min('new_price');
        $max_price = $products->max('new_price');
        if ($request->min_price && $request->max_price) {
            $products = $products->where('new_price', '>=', $request->min_price);
            $products = $products->where('new_price', '<=', $request->max_price);
        }

        $selectedChildcategories = $request->input('childcategory', []);
        $products = $products->when($selectedChildcategories, function ($query) use ($selectedChildcategories) {
            return $query->whereHas('childcategory', function ($subQuery) use ($selectedChildcategories) {
                $subQuery->whereIn('id', $selectedChildcategories);
            });
        });

        $products = $products->paginate(24);
        // return $products;
        $impproducts = Product::where(['status' => 1, 'topsale' => 1])
            ->with('image')
            ->limit(6)
            ->select('id', 'name', 'slug')
            ->get();

        return view('frontEnd.layouts.pages.subcategory', compact('subcategory', 'products', 'impproducts', 'childcategories', 'max_price', 'min_price'));
    }


    public function products($slug, Request $request)
    {
        $childcategory = Childcategory::where(['slug' => $slug, 'status' => 1])->first();
        $childcategories = Childcategory::where('subcategory_id', $childcategory->subcategory_id)->get();
        $products = Product::where(['status' => 1, 'childcategory_id' => $childcategory->id])->with('category')
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'whole_sell_price', 'category_id', 'subcategory_id', 'childcategory_id', 'stock', 'specification');


        // return $request->sort;
        if ($request->sort == 1) {
            $products = $products->orderBy('created_at', 'desc');
        } elseif ($request->sort == 2) {
            $products = $products->orderBy('created_at', 'asc');
        } elseif ($request->sort == 3) {
            $products = $products->orderBy('new_price', 'desc');
        } elseif ($request->sort == 4) {
            $products = $products->orderBy('new_price', 'asc');
        } elseif ($request->sort == 5) {
            $products = $products->orderBy('name', 'asc');
        } elseif ($request->sort == 6) {
            $products = $products->orderBy('name', 'desc');
        } else {
            $products = $products->latest();
        }

        $min_price = $products->min('new_price');
        $max_price = $products->max('new_price');
        if ($request->min_price && $request->max_price) {
            $products = $products->where('new_price', '>=', $request->min_price);
            $products = $products->where('new_price', '<=', $request->max_price);
        }

        $products = $products->paginate(24);
        // return $products;
        $impproducts = Product::where(['status' => 1, 'topsale' => 1])
            ->with('image')
            ->limit(6)
            ->select('id', 'name', 'slug')
            ->get();

        return view('frontEnd.layouts.pages.childcategory', compact('childcategory', 'products', 'impproducts', 'min_price', 'max_price', 'childcategories'));
    }

    

    public function details($slug)
    {
        $details = Product::where(['slug' => $slug, 'status' => 1])
            ->with('image', 'images', 'category', 'subcategory', 'childcategory')
            ->firstOrFail();
        $products = Product::where(['category_id' => $details->category_id, 'status' => 1])
            ->with('image')
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'whole_sell_price', 'stock', 'specification','warranty')
            ->latest()
            ->limit(10)
            ->get();
        $also__like_pro = Category::where(['status' => 1])
            ->orderBy('id', 'ASC')
            ->with(['products', 'products.image'])
            ->get()
            ->map(function ($query) {
                $query->setRelation('products', $query->products->take(5));
                return $query;
            });

        $order_sold = OrderDetails::where('product_id', $details->id)->sum('qty');
        // return $also__like_pro;
        $ourservice = OurService::where('status', 1)->get();
        view()->share('ourservice', $ourservice);

        $brand = Brand::where('status', 1)->get();
        view()->share('brand', $brand);

        $shippingcharge = ShippingCharge::where(['status' => 1, 'pos' => 0])->get();
        $reviews = Review::where('product_id', $details->id)->get();
        $productcolors = Productcolor::where('product_id', $details->id)
            ->with('color')
            ->get();
        // return $productcolors;
        $productsizes = Productsize::where('product_id', $details->id)
            ->with('size')
            ->get();

        return view('frontEnd.layouts.pages.details', compact('details', 'order_sold', 'products', 'shippingcharge', 'productcolors', 'productsizes', 'reviews', 'also__like_pro', 'brand'));
    }
    public function quickview(Request $request)
    {
        $data['data'] = Product::where(['id' => $request->id, 'status' => 1])->with('images')->withCount('reviews')->first();
        $data = view('frontEnd.layouts.ajax.quickview', $data)->render();
        if ($data != '') {
            echo $data;
        }
    }
    public function livesearch(Request $request)
    {
        $products = Product::select('id', 'name', 'slug', 'new_price', 'old_price')
            ->where('status', 1)
            ->with('image');

        if ($request->keyword) {
            $products = $products->where('name', 'LIKE', '%' . $request->keyword . "%");
        }

        if ($request->category) {
            $products = $products->where('category_id', $request->category);
            return $products;
        }
        $products = $products->get();
        if (empty($request->category) && empty($request->keyword)) {
            $products = [];
        }

        return view('frontEnd.layouts.ajax.search', compact('products'));
    }


    // public function livesearch(Request $request)
    // {
    //     $products = Product::select('id', 'name', 'slug', 'new_price', 'old_price')
    //         ->where('status', 1)
    //         ->with('image');
    //     if ($request->keyword) {
    //         $products = $products->where('name', 'LIKE', '%' . $request->keyword . "%");
    //     }
    //     if ($request->category) {
    //         $products = $products->where('category_id', $request->category);
    //     }
    //     $products = $products->get();

    //     if (empty($request->category) && empty($request->keyword)) {
    //         $products = [];
    //     }
    //     return view('frontEnd.layouts.ajax.search', compact('products'));
    // }
    // public function search(Request $request)
    // {
    //     $products = Product::select('id', 'name', 'slug', 'new_price', 'old_price')
    //         ->where('status', 1)
    //         ->with('image');

    //     if ($request->keyword) {
    //         $products = $products->where('name', 'LIKE', '%' . $request->keyword . "%");
    //     }
    //     if ($request->category) {
    //         $products = $products->where('category_id', $request->category);
    //     }
    //     $products = $products->paginate(36);
    //     $keyword = $request->keyword;
    //     return view('frontEnd.layouts.pages.search', compact('products', 'keyword'));
    // }

    public function search(Request $request)
    {
        $sellers = Seller::select('id', 'name', 'district')
            ->where('status', 'active');
        //return $sellers;

        
        if ($request->category) {
            $sellers = $sellers->where('district', $request->category);
        }

        
        $products = Product::select('id', 'name', 'slug', 'new_price', 'old_price')
            ->where('status', 1)
            ->with('image');

        if ($request->keyword) {
            $products = $products->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        if ($request->category) {
            $sellerIds = $sellers->pluck('id'); 
            $products = $products->whereIn('seller_id', $sellerIds);
        }

        $products = $products->paginate(36);
        $keyword = $request->keyword;

        return view('frontEnd.layouts.pages.search', compact('products', 'keyword'));
    }
    
    


    public function shipping_charge(Request $request){
        
        if ($request->id == NULL) {
            Session::put('shipping', 0);
        } else {
            $shipping = District::where(['id' => $request->id])->first();
            Session::put('shipping', ($shipping->shippingfee * $this->seller_order()));
        }
        return view('frontEnd.layouts.ajax.cart');
    }



    public function payment_shurjopay()
    {
        return view('frontEnd.layouts.ajax.shurjopay');
    }
    public function payment_bkash()
    {
        return view('frontEnd.layouts.ajax.bkash');
    }
    public function payment_nagad()
    {
        return view('frontEnd.layouts.ajax.nagad');
    }
    public function payment_rocket()
    {
        return view('frontEnd.layouts.ajax.rocket');
    }

    public function advanced_payment()
    {
        Session::put('advanced_pay', 1);
        return view('frontEnd.layouts.ajax.cart');
    }

    public function forget_advanced()
    {
        Session::forget('advanced_pay');
        return view('frontEnd.layouts.ajax.cart');
    }

    public function contact(Request $request)
    {
        return view('frontEnd.layouts.pages.contact');
    }

    public function page($slug)
    {
        $page = CreatePage::where('slug', $slug)->firstOrFail();
        return view('frontEnd.layouts.pages.page', compact('page'));
    }
    public function districts(Request $request)
    {
        $areas = District::where(['district' => $request->id])->pluck('area_name', 'id');
        return response()->json($areas);
    }
    public function shipping_districts(Request $request)
    {
        $areas = District::where(['district' => $request->id])->pluck('area_name', 'id');
        $shopping = Cart::instance('shopping')->content();        

        $site_setting = GeneralSetting::where('status', 1)->select('own_shipping', 'diff_shipping')->first();

        $shippingfee = 0;

        foreach ($shopping as $cart) {
            $seller = Seller::find($cart->options->seller_id);
            if ($seller) {
                if ($seller->district == $request->id) {
                    $shippingfee += $site_setting->own_shipping;
                } else {
                    $shippingfee += $site_setting->diff_shipping;
                }
            }
        }

        Session::put('shipping', $shippingfee);

        return response()->json([
            'html' => view('frontEnd.layouts.ajax.cart')->render(),
            'areas' => $areas
        ]);
    }
    public function campaign($slug)
    {
        $campaign_data = Campaign::where('slug', $slug)->with('images')->first();
        $districts = District::distinct()->select('district')->orderBy('district', 'asc')->get();
        $bkash_gateway = PaymentGateway::where(['status' => 1, 'type' => 'bkash'])->first();
        $shurjopay_gateway = PaymentGateway::where(['status' => 1, 'type' => 'shurjopay'])->first();
        $areas = District::where(['district' => $campaign_data->district])->select('area_name', 'id')->get();
        $product = Product::where('id', $campaign_data->product_id)
            ->where('status', 1)
            ->with('image')
            ->first();
        Cart::instance('shopping')->destroy();
        $cart_count = Cart::instance('shopping')->count();
        if ($cart_count == 0) {
            Cart::instance('shopping')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->new_price,
                'options' => [
                    'slug' => $product->slug,
                    'image' => $product->image->image,
                    'old_price' => $product->old_price,
                    'purchase_price' => $product->purchase_price,
                    'seller_id'=>$product->seller_id,
                ],
            ]);
        }
        $productcolors = Productcolor::where('product_id', $campaign_data->product_id)
            ->with('color')
            ->get();

        $productsizes = Productsize::where('product_id', $campaign_data->product_id)
            ->with('size')
            ->get();
        $shippingcharge = ShippingCharge::where(['status' => 1, 'pos' => 0])->get();
        $select_charge = ShippingCharge::where(['status' => 1, 'pos' => 0])->first();
        Session::put('shipping', $select_charge->amount);
        // return Cart::instance('shopping')->content();
        return view('frontEnd.layouts.pages.campaign.campaign', compact('campaign_data', 'product', 'shippingcharge','districts','areas','bkash_gateway','shurjopay_gateway', 'productcolors', 'productsizes'));
    }
    

    public function payment_success(Request $request)
    {
        $order_id = $request->order_id;
        $shurjopay_service = new ShurjopayController();
        $json = $shurjopay_service->verify($order_id);
        $data = json_decode($json);

        if ($data[0]->sp_code != 1000) {
            Toastr::error('Your payment failed, try again', 'Oops!');
            if ($data[0]->value1 == 'customer_payment') {
                return redirect()->route('home');
            } else {
                return redirect()->route('home');
            }
        }

        if ($data[0]->value1 == 'customer_payment') {

            // order data save
            $order = new Order();
            $order->invoice_id = $data[0]->id;
            $order->amount = $data[0]->amount;
            $order->customer_id = Auth::guard('customer')->user()->id;
            $order->order_status = $data[0]->bank_status;
            $order->save();

            // payment data save
            $payment = new Payment();
            $payment->order_id = $order->id;
            $payment->customer_id = Auth::guard('customer')->user()->id;
            $payment->payment_method = 'shurjopay';
            $payment->amount = $order->amount;
            $payment->trx_id = $data[0]->bank_trx_id;
            $payment->sender_number = $data[0]->phone_no;
            $payment->payment_status = 'paid';
            $payment->save();
            // order details data save
            foreach (Cart::instance('shopping')->content() as $cart) {
                $order_details = new OrderDetails();
                $order_details->order_id = $order->id;
                $order_details->product_id = $cart->id;
                $order_details->product_name = $cart->name;
                $order_details->purchase_price = $cart->options->purchase_price;
                $order_details->sale_price = $cart->price;
                $order_details->qty = $cart->qty;
                $order_details->save();
            }

            Cart::instance('shopping')->destroy();
            Toastr::error('Thanks, Your payment send successfully', 'Success!');
            return redirect()->route('home');
        }

        Toastr::error('Something wrong, please try agian', 'Error!');
        return redirect()->route('home');
    }
    public function payment_cancel(Request $request)
    {
        $order_id = $request->order_id;
        $shurjopay_service = new ShurjopayController();
        $json = $shurjopay_service->verify($order_id);
        $data = json_decode($json);

        Toastr::error('Your payment cancelled', 'Cancelled!');
        if ($data[0]->sp_code != 1000) {
            if ($data[0]->value1 == 'customer_payment') {
                return redirect()->route('home');
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function offers()
    {
        return view('frontEnd.layouts.pages.offers');
    }

    public function wholesell_store(Request $request)
    {
        $this->validate($request, [
            'payment_method' => 'required',
            'sender_number' => 'required',
            'transaction' => 'required',
        ]);
        $customer_id = Auth::guard('customer')->user()->id ?? Session::get('id');
        $package = RegistrationCharge::find($request->package_id);
        $Wholesell = new WholesellCustomer();
        $Wholesell->customer_id = $customer_id;
        $Wholesell->sender_number = $request->sender_number;
        $Wholesell->transaction = $request->transaction;
        $Wholesell->type = $request->type;
        $Wholesell->payment_method = $request->payment_method;
        $Wholesell->package_id = $package->id;
        $Wholesell->days = $package->days;
        $Wholesell->amount = $package->charge;
        $Wholesell->status = 'pending';
        $Wholesell->save();

        $site_setting = GeneralSetting::where('status', 1)->first();
        $apiUrl = "https://quicksmsapp.com/Api/sms/campaign_api";
        $quickApi = "54ab22d2b79a3ee99438438319521c8d";
        $mobile =  $request->phone;
        $msg = "প্রিয়  গ্রাহক!\r\n আপনার একাউন্টটি সফল হয়েছে, অতি দ্রুত আপনার একাউন্টি সচল করা হবে $site_setting->name  এর সাথে থাকার জন্য ধন্যবাদ";
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

        Session::forget('id');
        Toastr::success('Thanks, Your request send successfully', 'Success!');
        return redirect()->route('customer.dashboard');
    }
    public function seller_order(){
        $cartItems = Cart::instance('shopping')->content();
        $seller_orders = [];
        foreach ($cartItems as $item) {
            $sellerId = $item->options->seller_id;
            if (!in_array($sellerId, $seller_orders)) {
                $seller_orders[] = $sellerId;  // Add only if it's not already in the array
            }
        }
        return count($seller_orders);
    }

}
