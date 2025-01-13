<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistrationCharge;
use Toastr;
use Str;

class RegistrationChargeController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:charge-list|charge-create|charge-edit|charge-delete', ['only' => ['index','store']]);
         $this->middleware('permission:charge-create', ['only' => ['create','store']]);
         $this->middleware('permission:charge-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:charge-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = RegistrationCharge::orderBy('id','DESC')->get();
        return view('backEnd.wholesellercustomer.registercharge.index',compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.wholesellercustomer.registercharge.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'days' => 'required',
            'charge' => 'required',
            'status' => 'required',
        ]);

        $input = $request->all();
        RegistrationCharge::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('registrationcharges.index');
    }
    
    public function edit($id)
    {
        $edit_data = RegistrationCharge::find($id);
        return view('backEnd.wholesellercustomer.registercharge.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'days' => 'required',
            'charge' => 'required',
        ]);
        $input = $request->except('hidden_id');
        $update_data = RegistrationCharge::find($request->hidden_id);
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('registrationcharges.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = RegistrationCharge::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = RegistrationCharge::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = RegistrationCharge::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
