<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\MuliImg;
use App\Models\Brand;
use App\Models\User;
use App\Models\Product;
use \Intervention\Image\Facades\Image; 
use Carbon\Carbon;

class IndexController extends Controller
{

    public function Index(){
        $skip_category_0 = Category::skip(0)->first();
        $skip_product_0 = Product::where('status',1)->where('category_id',$skip_category_0->id)->orderBy('id','DESC')->limit(5)->get();

        // $skip_category_2 = Category::skip(2)->first();
        // $skip_product_2 = Product::where('status',1)->where('category_id',$skip_category_2->id)->orderBy('id','DESC')->limit(5)->get();

        // $skip_category_7 = Category::skip(7)->first();
        // $skip_product_7 = Product::where('status',1)->where('category_id',$skip_category_7->id)->orderBy('id','DESC')->limit(5)->get();

        return view('frontend.index',compact('skip_category_0'));
        //,'skip_product_0','skip_category_2','skip_product_2','skip_category_7','skip_product_7'
        
    } // End Method 


    public function VendorDetails($id){

        $vendor = User::findOrFail($id);
        $vproduct = Product::where('vendor_id',$id)->get();
        return view('frontend.vendor.vendor_details',compact('vendor','vproduct'));

     } // End Method 

     
     public function CatWiseProduct(Request $request,$id,$slug){
        $products = Product::where('status',1)->where('category_id',$id)->orderBy('id','DESC')->get();
        $categories = Category::orderBy('category_name','ASC')->get();
  
        return view('frontend.product.category_view',compact('products','categories'));
  
       }// End Method 

     public function VendorAll(){

        $vendors = User::where('status','active')->where('role','vendor')->orderBy('id','DESC')->get();
        return view('frontend.vendor.vendor_all',compact('vendors'));

     } // End Method 


    public function ProductDetails($id,$slug){
        $product = Product::findOrFail($id);
        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);
        $multiImage = MuliImg::where('product_id',$id)->get();

        $cat_id = $product->category_id;
        $relatedProduct = Product::where('category_id',$cat_id)->where('id','!=',$id)->orderBy('id','DESC')->limit(4)->get();

        return view('frontend.product.product_details',compact('product','product_color','product_size','multiImage','relatedProduct'));
    }
}
