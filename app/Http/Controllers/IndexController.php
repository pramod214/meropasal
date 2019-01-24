<?php

namespace App\Http\Controllers;

use App\Category;
use App\Products;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $products = Products::latest()->get();
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        return view('frontend.index',compact('products','categories'));
    }
}
