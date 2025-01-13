<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCategory;
use Toastr;

class VideoCategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:video-category-list|video-category-create|video-category-edit|video-category-delete', ['only' => ['index','store']]);
         $this->middleware('permission:video-category-create', ['only' => ['create','store']]);
         $this->middleware('permission:video-category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:video-category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = VideoCategory::orderBy('id','DESC')->get();
        return view('backEnd.video.category.index',compact('data'));
    }
    public function create()
    {
        $categories = VideoCategory::orderBy('id','DESC')->select('id','name')->get();
        return view('backEnd.video.category.create',compact('categories'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        // return $input;
        VideoCategory::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('video_category.index');
    }
    
    public function edit($id)
    {
        $edit_data = VideoCategory::find($id);
        return view('backEnd.video.category.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $update_data = VideoCategory::find($request->id);
        $input = $request->all();
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('video_category.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = VideoCategory::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = VideoCategory::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = VideoCategory::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
