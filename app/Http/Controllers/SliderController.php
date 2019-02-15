<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use Image;
use File;
use Illuminate\Support\Facades\Input;
use Session;


class SliderController extends Controller
{
    public function storeSlider(Request $request){
        if($request->isMethod('post')){
            $slider = new Slider();
            $data = $request->all();

            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(100,2000).'.'.$extension;

                    $large_image_path = 'public/adminpanel/uploads/slider/'.$filename;

                    Image::make($image_tmp)->save($large_image_path);
                    $slider->image = $filename;
                }
            }
            $slider->shop_Name = ucwords(strtolower($data['shop_Name']));
            $slider->title = ucwords($data['title']);
            $slider->body = ucwords($data['body']);
            $slider->save();
            return redirect()->route('view.sliders')->with('flash_message_success','Slider Added Successfully');
        }
        return view('admin.slider.addSlider');
    }

    public function viewSlider(){
        $sliders = Slider::latest()->get();
        return view('admin.slider.viewSliders',compact('sliders'));
    }

    public function editSlider(Request $request,$id){
        $slider = Slider::where(['id'=>$id])->first();
        if($request->isMethod('post')){
            $data = $request->all();
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(100,2000).'.'.$extension;

                    $large_image_path = 'public/adminpanel/uploads/slider/'.$filename;

                    Image::make($image_tmp)->save($large_image_path);
                    $slider->image = $filename;
                }
            }
            $slider->shop_Name = ucwords(strtolower($data['shop_Name']));
            $slider->title = ucwords($data['title']);
            $slider->body = ucwords($data['body']);
            $slider->save();
            return redirect()->route('view.sliders')->with('flash_message_info','Slider Updated Successfully');
        }
        return view('admin.slider.editSlider',compact('slider'));
    }

    public function deleteSlider($id){
        $slider = Slider::findOrFail($id)->first();
        $large_image_path = 'public/adminpanel/uploads/slider/';
        if(file_exists($large_image_path.$slider->image)){
            unlink($large_image_path.$slider->image);
        }
        $slider->delete();
        return redirect()->back()->with('flash_message_info','Slider Updated Successfully');

    }
}
