<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\VideoCategory;
use Image;
use Toastr;
use Str;
use File;

class VideoController extends Controller
{
     public function index(Request $request)
    {
        $data = Video::orderBy('id','DESC')->with('category')->get();
        return view('backEnd.video.index',compact('data'));
    }
    public function create()
    {   
        $categories = VideoCategory::orderBy('id','DESC')->select('id','name')->get();
        // return $categories;
        return view('backEnd.video.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        Video::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('video.index');
    }
    
    public function edit($id)
    {
        $edit_data = Video::find($id);
        $categories = VideoCategory::select('id','name')->get();
        // return $categories;
        return view('backEnd.video.edit',compact('edit_data','categories'));
    }
    
    public function update(Request $request)
    {
        
        $this->validate($request, [
            'title' => 'required',
            'video' => 'required',
            'status' => 'required',
        ]);
        $input = $request->except('hidden_id');
        $update_data = Video::find($request->hidden_id);
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('video.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = Video::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Video::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Video::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
