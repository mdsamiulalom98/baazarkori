<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PackagingCategory;
use Toastr;

class PackagingCategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:package-category-list|package-category-create|package-category-edit|package-category-delete', ['only' => ['index','store']]);
         $this->middleware('permission:package-category-create', ['only' => ['create','store']]);
         $this->middleware('permission:package-category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:package-category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = PackagingCategory::orderBy('id','DESC')->get();
        return view('backEnd.package.category.index',compact('data'));
    }
    public function create()
    {
        $categories = PackagingCategory::orderBy('id','DESC')->select('id','name')->get();
        return view('backEnd.package.category.create',compact('categories'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        PackagingCategory::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('package_category.index');
    }
    
    public function edit($id)
    {
        $edit_data = PackagingCategory::find($id);
        return view('backEnd.package.category.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $update_data = PackagingCategory::find($request->id);
        $input = $request->all();
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('package_category.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = PackagingCategory::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = PackagingCategory::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = PackagingCategory::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
