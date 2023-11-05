<?php

namespace App\Http\Controllers\Backend;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\MultiImg;
use App\Models\Brand;
use App\Models\Product;
use Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ProductController extends Controller

{
    public function AllProduct(){
        $products = Product::latest()->get();
        return view('backend.product.product_all',compact('products'));
    } // End Method 


    public function AddProduct(){

        return view('backend.product.product_add');

    } // End Method 
}
