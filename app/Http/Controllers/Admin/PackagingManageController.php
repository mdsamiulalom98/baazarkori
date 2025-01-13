<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PackagingCategory;
use App\Models\PackagingManage;
use Toastr;
use Image;
use File;

class PackagingManageController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:package-list|package-create|package-edit|package-delete', ['only' => ['index','store']]);
         $this->middleware('permission:package-create', ['only' => ['create','store']]);
         $this->middleware('permission:package-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:package-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = PackagingManage::orderBy('id','DESC')->with('category')->get();
        return view('backEnd.package.index',compact('data'));
    }
    public function create()
    {
        $categories = PackagingCategory::orderBy('id','DESC')->select('id','name')->get();
        return view('backEnd.package.create',compact('categories'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'status' => 'required',
        ]);
        

        $input = $request->all();
        $input['status'] = $request->status?1:0;
        //return $input;
        PackagingManage::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('packages.index');
    }
    
    public function edit($id)
    {
        $edit_data = PackagingManage::find($id);
        $categories = PackagingCategory::select('id','name')->get();
        return view('backEnd.package.edit',compact('edit_data','categories'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
        ]);
        $update_data = PackagingManage::find($request->id);
        $input = $request->all();

        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('packages.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = PackagingManage::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = PackagingManage::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = PackagingManage::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
