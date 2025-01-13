<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Productimage;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Productcolor;
use App\Models\Productsize;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SellerProductController extends Controller
{
    public function index(Request $request)
    {
        $data = Product::where('seller_id',Auth::guard('seller')->user()->id)->orderBy('id','DESC')->with('image','category')->get();
        return view('frontEnd.seller.pages.product_manage',compact('data'));
    }
    public function create()
    {
        $categories = Category::where('parent_id','=','0')->where('status',1)->select('id','name','status')->get();
        $brands = Brand::where('status','1')->select('id','name','status')->get();

        $colors = Color::where('status','1')->get();
        $sizes = Size::where('status','1')->get();
        $seller_info = Auth::guard('seller')->user();
        if ($seller_info->name && $seller_info->phone && $seller_info->email && $seller_info->address && $seller_info->district && $seller_info->area && $seller_info->nid1 && $seller_info->nid2 && $seller_info->owner_name && $seller_info->nidnum) {
             return view('frontEnd.seller.pages.product_add',compact('categories','brands','colors','sizes'));  
        } 
        Toastr::error('Please Fill in your complete information ', 'Sorry!');
        return redirect()->route('seller.profile_edit');
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
        $last_id = Product::orderBy('id', 'desc')->first()->id+1;
        $input = $request->except(['image', 'proSize', 'proColor']);
        $input['slug'] = strtolower(Str::slug($request->name.'-'.$last_id));
        $input['status'] = 0;
        $input['approval'] = 0;
        $input['seller_id'] = Auth::guard('seller')->user()->id;
        $save_data = Product::create($input);
         //return $input;
        $save_data->sizes()->attach($request->proSize);
        $save_data->colors()->attach($request->proColor);

        // image with intervention
        $images = $request->file('image');
        if($images){
            foreach ($images as $key => $image) {
                $name =  time().'-'.$image->getClientOriginalName();
                $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
                $name = strtolower(Str::slug($name));
                $uploadpath = 'public/uploads/product/';
                $imageUrl = $uploadpath.$name;
                $img=Image::make($image->getRealPath());
                $img->encode('webp', 100);
                $width = 1000;
                $height = 1000;
                $img->resize($width, $height);
                $img->save($imageUrl);

                $pimage             = new Productimage();
                $pimage->product_id = $save_data->id;
                $pimage->image      = $imageUrl;
                $pimage->save();
            }

        }
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('seller.products.index');
    }

    public function edit($id)
    {
        $edit_data = Product::with('images')->where(['seller_id'=>Auth::guard('seller')->user()->id])->findOrfail($id);
        $categories = Category::where('parent_id','=','0')->where('status',1)->select('id','name','status')->get();
        $categoryId = Product::find($id)->category_id;
        $subcategoryId = Product::find($id)->subcategory_id;
        $subcategory = Subcategory::where('category_id', '=', $categoryId)->select('id','subcategoryName','status')->get();
        $childcategory = Childcategory::where('subcategory_id', '=', $subcategoryId)->select('id', 'childcategoryName', 'status')->get();

        $brands = Brand::where('status','1')->select('id','name','status')->get();

        $totalsizes = Size::where('status',1)->get();
        $totalcolors = Color::where('status',1)->get();
        $selectcolors = Productcolor::where('product_id',$id)->get();
        $selectsizes = Productsize::where('product_id',$id)->get();

        return view('frontEnd.seller.pages.product_edit',compact('edit_data','subcategory','childcategory','categories','brands','totalsizes','totalcolors','selectcolors','selectsizes'));
    }

    public function update(Request $request)
    {
         $this->validate($request, [
            'name' => 'required',
            'purchase_price' => 'required',
            'new_price' => 'required',
            'stock' => 'required',
        ]);

        $update_data = Product::find($request->id);
        $input = $request->all();
        $input = $request->except(['image', 'proSize', 'proColor']);
        $input['slug'] = strtolower(Str::slug($request->name.'-'.$update_data->id));
        $input['status'] = 0;
        $input['approval'] = 0;
        // dd($input);
        $update_data->update($input);

        $update_data->sizes()->sync($request->proSize);
        $update_data->colors()->sync($request->proColor);

        // image with intervention
        $images = $request->file('image');
        if($images){
            foreach ($images as $key => $image) {
                $name =  time().'-'.$image->getClientOriginalName();
                $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
                $name = strtolower(Str::slug($name));
                $uploadpath = 'public/uploads/product/';
                $imageUrl = $uploadpath.$name;
                $img=Image::make($image->getRealPath());
                $img->encode('webp', 100);
                $width = 1500;
                $height = 1500;
                $img->resize($width, $height);
                $img->save($imageUrl);

                $pimage             = new Productimage();
                $pimage->product_id = $update_data->id;
                $pimage->image      = $imageUrl;
                $pimage->save();
            }
        }

        Toastr::success('Success','Data update successfully');
        return redirect()->route('seller.products.index');
    }

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
        return "wait";
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
}
