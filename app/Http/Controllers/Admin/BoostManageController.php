<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoostManage;
use Toastr;
use Image;
use File;

class BoostManageController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:boost-list|boost-create|boost-edit|boost-delete', ['only' => ['index','store']]);
         $this->middleware('permission:boost-create', ['only' => ['create','store']]);
         $this->middleware('permission:boost-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:boost-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = BoostManage::orderBy('id','DESC')->get();
        return view('backEnd.boost.index',compact('data'));
    }
    public function create()
    {
        return view('backEnd.boost.create');
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
        BoostManage::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('boosts.index');
    }
    
    public function edit($id)
    {
        $edit_data = BoostManage::find($id);
        return view('backEnd.boost.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
        ]);
        $update_data = BoostManage::find($request->id);
        $input = $request->all();

        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('boosts.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = BoostManage::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = BoostManage::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = BoostManage::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }

}
