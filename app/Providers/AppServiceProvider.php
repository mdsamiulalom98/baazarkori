<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\GeneralSetting;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SocialMedia;
use App\Models\Contact;
use App\Models\CreatePage;
use App\Models\OrderStatus;
use App\Models\EcomPixel;
use App\Models\GoogleTagManager;
use App\Models\Order;
use App\Models\Product;
use App\Models\Banner;
use App\Models\PaymentGateway;
use App\Models\FreeShipping;
use App\Models\WholesellCustomer;
use App\Models\Newsticker;
use App\Models\Wallet;
use App\Models\District;
use App\Models\Sellerdeduct;
use Illuminate\Support\Facades\Config;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       $shurjopay = PaymentGateway::where(['status' => 1, 'type' => 'shurjopay'])->first();
        if ($shurjopay) {

            Config::set(['shurjopay.apiCredentials.username' => $shurjopay->username]);
            Config::set(['shurjopay.apiCredentials.password' => $shurjopay->password]);
            Config::set(['shurjopay.apiCredentials.prefix' => $shurjopay->prefix]);
            Config::set(['shurjopay.apiCredentials.return_url' => $shurjopay->success_url]);
            Config::set(['shurjopay.apiCredentials.cancel_url' => $shurjopay->return_url]);
            Config::set(['shurjopay.apiCredentials.base_url' => $shurjopay->base_url]);
        }
        $generalsetting = GeneralSetting::where('status',1)->limit(1)->first();
        view()->share('generalsetting',$generalsetting);

        $districts = District::distinct()->select('district')->orderBy('district', 'asc')->get();
        view()->share('districts', $districts);

        // $districts = District::select('district')->get();
        // view()->share('districts',$districts);


        $sidecategories = Category::where('parent_id','=','0')->where('status',1)->select('id','name','slug','status','image')->get();
        view()->share('sidecategories',$sidecategories);

        $menucategories = Category::where('status',1)->select('id','name','slug','status','icon','image','sort')->orderBy('sort','ASC')->get();
        view()->share('menucategories',$menucategories);

        $feature_products = Product::where(['status' => 1, 'feature_product' => 1])
            ->orderBy('id', 'DESC')
            ->select('id', 'name', 'slug', 'new_price', 'old_price','stock','specification')
            ->with('prosizes', 'procolors')
            ->limit(3)->get();
        view()->share('feature_products',$feature_products);

        $toprateds = Product::where(['status' => 1, 'toprated' => 1])
            ->orderBy('id', 'DESC')
            ->select('id', 'name', 'slug', 'new_price', 'old_price','stock','specification')
            ->with('prosizes', 'procolors')
            ->limit(3)->get();
        view()->share('toprateds',$toprateds);

        $on_sales = Product::where(['status' => 1, 'on_sale' => 1])
            ->orderBy('id', 'DESC')
            ->select('id', 'name', 'slug', 'new_price', 'old_price','stock','specification')
            ->with('prosizes', 'procolors')
            ->limit(3)->get();
        view()->share('on_sales',$on_sales);

        $footertopads = Banner::where(['status' => 1, 'category_id' => 6])
            ->orderBy('id', 'DESC')
            ->select('id', 'image', 'link')
            ->limit(2)->get();
        view()->share('footertopads',$footertopads);
        $contact = Contact::where('status',1)->first();
        view()->share('contact',$contact);

        $freeshipping = FreeShipping::where('status',1)->limit(1)->first();
        view()->share('freeshipping',$freeshipping);

        $socialicons = SocialMedia::where('status',1)->get();
        view()->share('socialicons',$socialicons);

        $pages = CreatePage::where('status',1)->get();
        view()->share('pages',$pages);

        // $pagesright = CreatePage::where('status',1)->skip(3)->limit(10)->get();
        // view()->share('pagesright',$pagesright);

        $cmnmenu = CreatePage::where('status',1)->get();
        view()->share('cmnmenu',$cmnmenu);

        $brands = Brand::where('status',1)->get();
        view()->share('brands',$brands);

        $neworder = Order::where('order_status','1')->count();
        view()->share('neworder',$neworder);

        $newrequestall = WholesellCustomer::where('status','pending')->count();
        view()->share('newrequestall',$newrequestall);

        $newwalletrequest = Wallet::where('status','pending')->count();
        view()->share('newwalletrequest',$newwalletrequest);

        $newsellerproduct = Product::where('status','pending')->count();
        view()->share('newsellerproduct',$newsellerproduct);

        $pendingorder = Order::where('order_status','1')->latest()->limit(9)->get();
        view()->share('pendingorder',$pendingorder);

        $cancelorder = Order::where('order_status','7')->latest()->get();
        view()->share('cancelorder',$cancelorder);

        $orderstatus = OrderStatus::get();
        view()->share('orderstatus',$orderstatus);

        $pixels = EcomPixel::where('status',1)->get();
        view()->share('pixels',$pixels);

        $gtm_code = GoogleTagManager::where('status',1)->get();
        view()->share('gtm_code',$gtm_code);

        $newstickers = Newsticker::where('status',1)->get();
        view()->share('newstickers',$newstickers);

        


    }
}
