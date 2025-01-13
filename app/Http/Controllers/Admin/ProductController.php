<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Productimage;
use App\Models\Productprice;
use App\Models\Productcolor;
use App\Models\Productsize;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use Toastr;
use File;
use Str;
use Image;
use DB;

class ProductController extends Controller
{
    public function getSubcategory(Request $request)
    {
        $subcategory = DB::table("subcategories")
        ->where("category_id", $request->category_id)
        ->pluck('subcategoryName', 'id');
        return response()->json($subcategory);
    }
    public function getChildcategory(Request $request)
    {
        $childcategory = DB::table("childcategories")
        ->where("subcategory_id", $request->subcategory_id)
        ->pluck('childcategoryName', 'id');
        return response()->json($childcategory);
    }
    
    
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    
    
    public function index(Request $request)
    {
        if($request->keyword){
            $data = Product::orderBy('id','DESC')->where('name', 'LIKE', '%' . $request->keyword . "%")->with('image','category')->paginate(50);
        }else{
            $data = Product::orderBy('id','DESC')->with('image','category')->paginate(50);
        }
        return view('backEnd.product.index',compact('data'));
    }
    public function create()
    {
        $categories = Category::where('parent_id','=','0')->where('status',1)->select('id','name','status')->with('childrenCategories')->get();
        $seller = Seller::where('status','active')->get();
        $brands = Brand::where('status','1')->select('id','name','status')->get();
        $colors = Color::where('status','1')->get();
        $sizes = Size::where('status','1')->get();
        return view('backEnd.product.create',compact('categories','brands','colors','sizes','seller'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'new_price' => 'required',
            'whole_sell_price' => 'required',
            'purchase_price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);
        $last_id = Product::orderBy('id', 'desc')->select('id')->first();
        $last_id = $last_id?$last_id->id+1:1;
        $input = $request->except(['image','files','proSize','proColor']);

        $input['slug'] = strtolower(preg_replace('/[\/\s]+/', '-', $request->name.'-'.$last_id));

        $input['status'] = $request->status?1:0;
        $input['topsale'] = $request->topsale?1:0;
        $input['feature_product'] = $request->feature_product?1:0;
        $input['on_sale'] = $request->on_sale ? 1 : 0;
        $input['advance'] = $request->advance ?? 0;
        $input['toprated'] = $request->toprated ? 1 : 0;
        $input['best_deals'] = $request->best_deals ? 1 : 0;
        $input['approval'] = 1;
        $input['seller_id'] = $request->seller_id;
        $input['product_code'] = 'P' . str_pad($last_id, 4, '0', STR_PAD_LEFT);
        $save_data = Product::create($input);
        $save_data->sizes()->attach($request->proSize);
        $save_data->colors()->attach($request->proColor);
        
        // image with intervention 
        $images = $request->file('image');
        if($images){
            foreach ($images as $key => $image) {
                $name =  time().'-'.$image->getClientOriginalName();
                $name = strtolower(preg_replace('/\s+/', '-', $name));
            	$uploadPath = 'public/uploads/product/';
            	$image->move($uploadPath,$name);
            	$imageUrl =$uploadPath.$name;

                $pimage             = new Productimage();
                $pimage->product_id = $save_data->id;
                $pimage->image      = $imageUrl;
                $pimage->save();
            }
            
        }
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('products.index');
    }
    
    public function edit($id)
    {
        $edit_data = Product::with('images')->find($id);
        $categories = Category::where('parent_id','=','0')->where('status',1)->select('id','name','status')->get();
        $seller = Seller::where('status','active')->select('id','name','status')->get();
        // return $categories;
        $categoryId = Product::find($id)->category_id;
        //return $categoryId;
        $sellerId = Product::find($id)->seller_id;
        $subcategoryId = Product::find($id)->subcategory_id;
        $subcategory = Subcategory::where('category_id', '=', $categoryId)->select('id','subcategoryName','status')->get();
        $childcategory = Childcategory::where('subcategory_id', '=', $subcategoryId)->select('id', 'childcategoryName', 'status')->get();
        $brands = Brand::where('status','1')->select('id','name','status')->get();
        $totalsizes = Size::where('status',1)->get();
        $totalcolors = Color::where('status',1)->get();
        $selectcolors = Productcolor::where('product_id',$id)->get();
        $selectsizes = Productsize::where('product_id',$id)->get();
        return view('backEnd.product.edit',compact('edit_data','categories', 'subcategory', 'childcategory', 'brands', 'selectcolors', 'selectsizes','totalsizes', 'totalcolors','seller'));
    }
    public function price_edit()
    {
        $products = DB::table('products')->select('id','name','status','old_price','new_price','stock')->where('status',1)->get();;
        return view('backEnd.product.price_edit',compact('products'));
    }
    public function price_update(Request $request)
{
    $ids = $request->ids;
    $oldPrices = $request->old_price;
    $newPrices = $request->new_price;
    $wholeSellPrices = $request->whole_sell_price;
    $stocks = $request->stock;
    foreach ($ids as $key => $id) {
        $product = Product::select('id','name','status','old_price','new_price','stock','whole_sell_price')->find($id);

        if ($product) {
            $product->update([
                'old_price' => $oldPrices[$key],
                'new_price' => $newPrices[$key],
                'whole_sell_price' => $wholeSellPrices[$key],
                'stock' => $stocks[$key],
            ]);
        }
    }
    Toastr::success('Success','Price update successfully');
    return redirect()->back();
}
    
    public function update(Request $request)
    {
       $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'new_price' => 'required',
            'whole_sell_price' => 'required',
            'purchase_price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);
          
        $update_data = Product::find($request->id);
        $input = $request->except(['image','files','proSize','proColor']);
        $last_id = Product::orderBy('id', 'desc')->select('id')->first();
        $input['slug'] = strtolower(preg_replace('/[\/\s]+/', '-', $request->name.'-'.$update_data->id));
        $input['status'] = $request->status?1:0;
        $input['topsale'] = $request->topsale?1:0;
        $input['feature_product'] = $request->feature_product?1:0;
        $input['on_sale'] = $request->on_sale?1:0;
        $input['toprated'] = $request->toprated?1:0;
        $input['advance'] = $request->advance ?? 0;
        $input['best_deals'] = $request->best_deals?1:0;
        $input['approval'] = 1;
        $update_data->update($input);
        $update_data->sizes()->sync($request->proSize);
        $update_data->colors()->sync($request->proColor);

        // image with intervention 
        $images = $request->file('image');
        if($images){
            foreach ($images as $key => $image) {
                $name =  time().'-'.$image->getClientOriginalName();
                $name = strtolower(preg_replace('/\s+/', '-', $name));
            	$uploadPath = 'public/uploads/product/';
            	$image->move($uploadPath,$name);
            	$imageUrl =$uploadPath.$name;

                $pimage             = new Productimage();
                $pimage->product_id = $update_data->id;
                $pimage->image      = $imageUrl;
                $pimage->save();
            }
        }
        

        Toastr::success('Success','Data update successfully');
        return redirect()->route('products.index');
    }


    // public function approveAllProducts()
    // {
    //     // যেসব প্রোডাক্টের approval ফিল্ড null, সেগুলোর approval ফিল্ডকে 1 সেট করা
    //     Product::whereNull('approval')->update(['approval' => 1]);

    //     // সফল হবার মেসেজ
    //     Toastr::success('Success', 'All products with null approval are approved successfully.');
    //     return redirect()->route('products.index');
    // }
     
    public function inactive(Request $request)
    {
        $inactive = Product::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Product::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Product::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
    public function imgdestroy(Request $request)
    { 
        $delete_data = Productimage::find($request->id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    } 
    public function pricedestroy(Request $request)
    { 
        $delete_data = Productprice::find($request->id);
        $delete_data->delete();
        Toastr::success('Success','Product price delete successfully');
        return redirect()->back();
    }
    public function update_deals(Request $request){
        $products = Product::whereIn('id', $request->input('product_ids'))->update(['topsale' => $request->status]);
        return response()->json(['status'=>'success','message'=>'Hot deals product status change']);
    }
    public function update_feature(Request $request){
        $products = Product::whereIn('id', $request->input('product_ids'))->update(['feature_product' => $request->status]);
        return response()->json(['status'=>'success','message'=>'Feature product status change']);
    }
    public function update_on_sale(Request $request){
        $products = Product::whereIn('id', $request->input('product_ids'))->update(['on_sale' => $request->status]);
        return response()->json(['status'=>'success','message'=>'On sale status change']);
    }
    public function update_best_deals(Request $request){
        $products = Product::whereIn('id', $request->input('product_ids'))->update(['best_deals' => $request->status]);
        return response()->json(['status'=>'success','message'=>'Best Deals status change']);
    }
    public function update_toprated(Request $request){
        $products = Product::whereIn('id', $request->input('product_ids'))->update(['toprated' => $request->status]);
        return response()->json(['status'=>'success','message'=>'Top rated status change']);
    }
    public function update_status(Request $request){
        $products = Product::whereIn('id', $request->input('product_ids'))->update(['status' => $request->status]);
        return response()->json(['status'=>'success','message'=>'Product status change successfully']);
    }
}
