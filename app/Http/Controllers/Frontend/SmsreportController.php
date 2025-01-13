<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Models\Seller;
use App\Models\Smsreport;

class SmsreportController extends Controller
{
    public function smsreport_add(){

       return view('frontEnd.seller.pages.smsreport_add');
   }
   public function smsreport_save(Request $request){
        
        $smsreport                 = new Smsreport();
        $smsreport->seller_id      = Auth::guard('seller')->user()->id;
        $smsreport->name           = Auth::guard('seller')->user()->name;
        $smsreport->email          = Auth::guard('seller')->user()->email;
        $smsreport->phone          = Auth::guard('seller')->user()->phone;
        $smsreport->report         = $request->report;
        $smsreport->status         = 'pending';

        
        // image with intervention 
        $image = $request->file('image');
        if ($image) {
            $name = time().'-'.$image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
            $name = strtolower(preg_replace('/\s+/', '-', $name)); // Replacing spaces with hyphens
            $uploadpath = 'public/uploads/report/';
            $imageUrl = $uploadpath.$name;

            // Resizing and saving the image
            $img = Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = 100;
            $height = 100;
            $img->height() > $img->width() ? $width = null : $height = null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio(); // Maintain aspect ratio
            });
            $img->save($imageUrl);

            // Save the image path in the smsreport model
            $smsreport->image = $imageUrl;
        }

        //return $smsreport;

        $smsreport->save(); 
        return redirect()->route('seller.smsreport')->with('success', 'SMS report has been saved successfully!');
    }
    public function smsreport(){
        $smsreport = Smsreport::select('id','phone','name','report','status','image')->where('seller_id',Auth::guard('seller')->user()->id)->get();
         //return $wallet;
       return view('frontEnd.seller.pages.smsreport',compact('smsreport'));
   }

}
