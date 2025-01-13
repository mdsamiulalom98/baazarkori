<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Toastr;
use Image;
use File;
use Str;
class CategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','store']]);
         $this->middleware('permission:category-create', ['only' => ['create','store']]);
         $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = Category::orderBy('sort','ASC')->with('category')->get();
        // return $data;
        return view('backEnd.category.index',compact('data'));
    }
    public function create()
    {
        $categories = Category::orderBy('id','DESC')->select('id','name')->get();
        return view('backEnd.category.create',compact('categories'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
        ]);
        // image with intervention 
        $image = $request->file('image');
        if($image){
        $name =  time().'-'.$image->getClientOriginalName();
        $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
        $name = strtolower(preg_replace('/\s+/', '-', $name));
        $uploadpath = 'public/uploads/category/';
        $imageUrl = $uploadpath.$name; 
        $img=Image::make($image->getRealPath());
        $img->encode('webp', 90);
        $width = "";
        $height = "";
        $img->height() > $img->width() ? $width=null : $height=null;
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($imageUrl);
        }else{
            $imageUrl = null;
        }
        
        // image with intervention 
        $image1 = $request->file('icon');
        if($image1){
        $name1 =  time().'-'.$image1->getClientOriginalName();
        $name1 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name1);
        $name1 = strtolower(preg_replace('/\s+/', '-', $name1));
        $uploadpath1 = 'public/uploads/category/';
        $imageUrl1 = $uploadpath1.$name1; 
        $img1=Image::make($image1->getRealPath());
        $img1->encode('webp', 90);
        $width1 = "";
        $height1 = "";
        $img1->height() > $img1->width() ? $width1=null : $height1=null;
        $img1->resize($width1, $height1, function ($constraint1) {
            $constraint1->aspectRatio();
        });
        $img1->save($imageUrl1);
        }else{
            $imageUrl1 = null;
        }
        
        // image with intervention 
        $image2 = $request->file('banner_image');
        if($image2){
        $name2 =  time().'-'.$image2->getClientOriginalName();
        $name2 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name2);
        $name2 = strtolower(preg_replace('/\s+/', '-', $name2));
        $uploadpath2 = 'public/uploads/category/';
        $imageUrl2 = $uploadpath2.$name2; 
        $img2=Image::make($image2->getRealPath());
        $img2->encode('webp', 90);
        $width2 = "";
        $height2 = "";
        $img2->height() > $img2->width() ? $width2=null : $height2=null;
        $img2->resize($width2, $height2, function ($constraint2) {
            $constraint2->aspectRatio();
        });
        $img2->save($imageUrl2);
        }else{
            $imageUrl2 = null;
        }

        $input = $request->all();
        $input['slug'] = strtolower(preg_replace('/\s+/', '-', $request->name));
        $input['slug'] = str_replace('/', '', $input['slug']);

        $input['parent_id'] = $request->parent_id?$request->parent_id:0;
        $input['front_view'] = $request->front_view ? 1 : 0;
        $input['image'] = $imageUrl;
        $input['icon'] = $imageUrl1;
        $input['banner_image'] = $imageUrl2;
        
        $sort = Category::count()+1;
        $input['sort'] = $sort;
        
        Category::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('categories.index');
    }
    
    public function edit($id)
    {
        $edit_data = Category::find($id);
        $categories = Category::select('id','name')->get();
        return view('backEnd.category.edit',compact('edit_data','categories'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $update_data = Category::find($request->id);
        $input = $request->all();
        
        $image = $request->file('image');
        if($image){
            // image with intervention 
            $name =  time().'-'.$image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/category/';
            $imageUrl = $uploadpath.$name; 
            $img=Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = "";
            $height = "";
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
        
        //icon image
        $image1 = $request->file('icon');
        if($image1){
            // image with intervention 
            $name1 =  time().'-'.$image1->getClientOriginalName();
            $name1 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name1);
            $name1 = strtolower(preg_replace('/\s+/', '-', $name1));
            $uploadpath1 = 'public/uploads/category/';
            $imageUrl1 = $uploadpath1.$name1; 
            $img1=Image::make($image1->getRealPath());
            $img1->encode('webp', 90);
            $width1 = "";
            $height1 = "";
            $img1->height() > $img1->width() ? $width=null : $height1=null;
            $img1->resize($width1, $height1, function ($constraint1) {
                $constraint1->aspectRatio();
            });
            $img1->save($imageUrl1);
            $input['icon'] = $imageUrl1;
            File::delete($update_data->icon);
        }else{
            $input['icon'] = $update_data->icon;
        }
        
        //banner image
        $image2 = $request->file('banner_image');
        if($image2){
            // image with intervention 
            $name2 =  time().'-'.$image2->getClientOriginalName();
            $name2 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name2);
            $name2 = strtolower(preg_replace('/\s+/', '-', $name2));
            $uploadpath2 = 'public/uploads/category/';
            $imageUrl2 = $uploadpath2.$name2; 
            $img2=Image::make($image2->getRealPath());
            $img2->encode('webp', 90);
            $width2 = "";
            $height2 = "";
            $img2->height() > $img2->width() ? $width2=null : $height2=null;
            $img2->resize($width2, $height2, function ($constraint2) {
                $constraint2->aspectRatio();
            });
            $img2->save($imageUrl2);
            $input['banner_image'] = $imageUrl2;
            File::delete($update_data->banner_image);
        }else{
            $input['banner_image'] = $update_data->banner_image;
        }
        
        $input['slug'] = strtolower(preg_replace('/\s+/', '-', $request->name));
        $input['slug'] = str_replace('/', '', $input['slug']);

        $input['parent_id'] = $request->parent_id?$request->parent_id:0;
        $input['front_view'] = $request->front_view ? 1 : 0;
        $input['status'] = $request->status?1:0;
        
        $sort = Category::count()+1;
        $input['sort'] = $sort;
        
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('categories.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = Category::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Category::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Category::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
    public function sort(Request $request)
    {
        $orderArray = $request->validate([
            'sort' => 'array|required',
        ])['sort'];
        
        $categories = Category::all();

        foreach ($categories as $category) {
            $newSortOrder = array_search($category->sort, $orderArray);
            if ($newSortOrder !== false) {
                $category->update(['sort' => $newSortOrder + 1]);
            }
        }
        
        Toastr::success('Success','Data Sorting successfully');
        return redirect()->back();
    }
}
