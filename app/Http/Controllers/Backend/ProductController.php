<?php

namespace App\Http\Controllers\Backend;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\MultiImg;
use App\Models\Brand;
use App\Models\User;
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

        $activeVendor = User::where('status','active')->where('role','vendor')->latest()->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        return view('backend.product.product_add',compact('brands','categories','activeVendor'));

    } // End Method 
}
