<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FreeShipping;
use Image;
use File;
use Toastr;

class FreeShippingController extends Controller
{
    public function index(Request $request)
    {
        $data = FreeShipping::orderBy('id','DESC')->get();
        return view('backEnd.freeshipping.index',compact('data'));
    }
    public function create()
    {
        return view('backEnd.freeshipping.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'status' => 'required',
        ]);
        
        $input = $request->all();
        
        FreeShipping::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('freeshipping.index');
    }
    
    public function edit($id)
    {
        $edit_data = FreeShipping::find($id);
        return view('backEnd.freeshipping.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        $update_data = FreeShipping::find($request->id);
        $input = $request->all();
       
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('freeshipping.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = FreeShipping::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = FreeShipping::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = FreeShipping::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
