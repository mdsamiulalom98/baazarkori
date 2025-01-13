<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Smsreport;
use Illuminate\Support\Arr;
use Toastr;
use Image;
use File;
use DB;

class SellersmsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:setting-list|setting-create|setting-edit|setting-delete', ['only' => ['index','store']]);
        $this->middleware('permission:setting-create', ['only' => ['create','store']]);
        $this->middleware('permission:setting-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:setting-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = Smsreport::orderBy('id','DESC')->get();
        //return $show_data;
        return view('backEnd.sellersms.index',compact('show_data'));
    } 

    public function smsshow($id)
    {
        $edit_data = Smsreport::find($id);
        return view('backEnd.sellersms.smsshow',compact('edit_data'));
    }   
 
    public function inactive(Request $request)
    {
        $inactive = Smsreport::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Smsreport::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Smsreport::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
