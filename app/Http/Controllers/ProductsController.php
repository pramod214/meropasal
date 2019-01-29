<?php

namespace App\Http\Controllers;

use App\Category;
use App\Products;
use App\ProductsAttribute;
use Illuminate\Http\Request;
use File;
use Image;
use Session;
use Illuminate\Support\Facades\Input;

class ProductsController extends Controller
{
    public function addproduct(Request $request){
        if($request ->isMethod('post')) {
            $data = $request->all();
            $product = new Products();
            if (empty($data['category_id'])) {
                return redirect()->back()->with('flash_message_error', 'Under Category is Missing');
            } else {
                $product->category_id = $data['category_id'];
            }
            $product->product_name = ucwords(strtolower($data['product_name']));
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            if (!empty($data['description'])) {
                $product->description = $data['description'];
            } else {
                $product->description = " ";
            }
            $product->price = $data['price'];


            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(1200,999999).'.'.$extension;
                    $large_image_path = 'public/adminpanel/uploads/products/large/'.$filename;
                    $medium_image_path = 'public/adminpanel/uploads/products/medium/'.$filename;
                    $small_image_path = 'public/adminpanel/uploads/products/small/'.$filename;
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                    $product->image = $filename;
                }
            }

            $product->save();
            Session::flash('success', 'Products Has Been Inserted Successfully');
            return redirect()->route('products.view');
        }
        $categories = Category::where(['parent_id'=>0])->get();
        $categories_dropdown = "<option selected disabled>Select</option>";
        foreach ($categories as $cat){
            $categories_dropdown .="<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach($sub_categories as $sub_cat){
                $categories_dropdown.="<option value='".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }


        return view('admin.products.add_product' ,compact('categories_dropdown'));
    }

        public function viewproducts(){
            $products = Products::latest()->get();

            foreach($products as $key => $val){
                $category_name = Category::where(['id' => $val->category_id])->first();
                $products[$key]->category_name = $category_name->name;
            }

        return view('admin.products.view_products',compact('products'));
    }

    public function editproduct(Request $request,$id){
        $productDetails = Products::where(['id'=>$id])->first();
        if($request ->isMethod('post')) {
            $data = $request->all();
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(1200,999999).'.'.$extension;
                    $large_image_path = 'public/adminpanel/uploads/products/large/'.$filename;
                    $medium_image_path = 'public/adminpanel/uploads/products/medium/'.$filename;
                    $small_image_path = 'public/adminpanel/uploads/products/small/'.$filename;
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                }else{
                    $filename = $data['current_image'];
                }
            }

            if(empty($data{'description'})){
                $data['description'] = "";
            }
            Products::where(['id'=>$id])->update(['category_id' => $data['category_id'],
                'product_name'=>ucwords(strtolower($data['product_name' ])),
                'product_code'=>$data['product_code'] ,
                'product_color'=>ucwords($data['product_color']),
                'price'=>$data['price'],
                'description'=>ucwords($data['description']),
                'image'=>$filename
            ]);
            Session::flash('info','Products Updated Successfully');
            return redirect()->route('products.view');
        }

        $categories = Category::where(['parent_id'=>0])->get();
        $categories_dropdown = "<option selected disabled>Select</option>";
        foreach($categories as $cat){
            $categories_dropdown .="<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach($sub_categories as $sub_cat){
                if($sub_cat->id == $productDetails->category_id){
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $categories_dropdown .= "<option value='".$sub_cat->id."' ".$selected."> &nbsp; --- &nbsp; ".$sub_cat->name." </option>";
            }
        }
        return view ('admin.products.edit_product', compact('productDetails', 'categories_dropdown'));
    }

    public function deleteproduct($id){
        $product = Products::findOrFail($id);
        $product->delete();
        Session::flash('danger','Product Deleted');
        return redirect()->route('products.view');
    }

    public function addAttributes(Request $request,$id=null){
        $productDetails = Products::with('attributes')->where(['id'=> $id])->first();

        if($request -> isMethod('post')){
           $data =$request->all();
            foreach($data['sku'] as $key => $val){
                if(!empty($val)){
                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $data['product_id'];
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
            }
            Session::flash('success', 'Attribute Has Been Added Successfully');
            return redirect()->back();
        }
        return view('admin.products.add_attributes',compact('productDetails'));
    }
    public function deleteAttribute($id){
        $attribute = ProductsssAttribute::findOrFail($id);
        $attribute -> delete();
        Session::flash('danger','Product Attribute Has Been Deleted Successfully');
        return redirect()->back();
    }


}
