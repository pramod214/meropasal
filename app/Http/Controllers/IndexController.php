<?php

namespace App\Http\Controllers;

use App\Category;
use App\Products;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $productAll = Products::latest()->where('status','=',1)->get();
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        return view('frontend.index',compact('productAll','categories'));
    }
}
