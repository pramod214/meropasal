<?php

namespace App\Http\Controllers;

use App\Category;
use App\ProductImage;
use App\Products;
use App\ProductsAttribute;
use Illuminate\Http\Request;

class FrontController extends Controller
{

    public function products($slug = null){
        $countCategory = Category::where(['slug'=>$slug])->count();
        if($countCategory==0){
            abort(404);
        }

//        Get all the categories and sub categories
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $categoriesDetails = Category::where(['slug' => $slug])->first();
        if($categoriesDetails->parent_id == 0){
//            if slug is main category
            $subCategories = Category::where(['parent_id' => $categoriesDetails->id])->get();
            foreach($subCategories as $subcat){
                $cat_ids[] = $subcat->id;
            }
            $productsAll = Products::whereIn('category_id', $cat_ids)->get();
            $productsAll = json_decode(json_encode($productsAll));
        } else {
//            if slug is subcategory
            $productsAll = Products::where(['category_id' => $categoriesDetails->id])->get();
        }
        return view ('frontend.products.listing', compact('categoriesDetails', 'productsAll', 'categories'));
    }
    public function product($id = null)
    {

       $productDetails = Products::with('attributes')->where('id',$id)->first();
       $categories = Category::with('categories')->where(['parent_id'=>0])->get();

       $productImage = ProductImage::where(['product_id'=>$id])->get();
       $total_stock = ProductsAttribute::where(['product_id'=>$id])->sum('stock');
       $relatedProducts = Products::findOrFail($id)->where(['category_id'=>$productDetails->category_id])->get();
       return view('frontend.products.detail',compact('productDetails','categories','productImage','total_stock', 'relatedProducts'));
    }


}
