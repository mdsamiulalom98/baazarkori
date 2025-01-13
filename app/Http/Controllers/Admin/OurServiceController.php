<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OurService;
use Toastr;
use Image;
use File;

class OurServiceController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:service-list|service-create|service-edit|service-delete', ['only' => ['index','store']]);
         $this->middleware('permission:service-create', ['only' => ['create','store']]);
         $this->middleware('permission:service-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:service-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = OurService::orderBy('id','DESC')->get();
        return view('backEnd.ourservice.index',compact('data'));
    }
    public function create()
    {
        // $categories = serviceCategory::orderBy('id','DESC')->select('id','name')->get();
        return view('backEnd.ourservice.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'service_des' => 'required',
            'icon' => 'required',
            'status' => 'required',
        ]);
        
        

        $input = $request->all();
        $input['status'] = $request->status?1:0;
        OurService::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('services.index');
    }
    
    public function edit($id)
    {
        $edit_data = OurService::find($id);
        // $categories = serviceCategory::select('id','name')->get();
        return view('backEnd.ourservice.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'service_des' => 'required',
        ]);
        $update_data = OurService::find($request->id);
        $input = $request->all();

        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('services.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = OurService::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = OurService::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = OurService::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
