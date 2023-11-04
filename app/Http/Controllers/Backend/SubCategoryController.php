<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;

class SubCategoryController extends Controller
{
     public function AllSubCategory(){
        $subcategories = SubCategory::latest()->get();
        return view('backend.subcategory.all_subcategory',compact('subcategories'));
    } // End Method 

    public function AddSubCategory(){

        $categories = Category::orderBy('category_name','ASC')->get();
      return view('backend.subcategory.add_subcategory',compact('categories'));

    }// End Method 


    public function StoreSubCategory(Request $request){ 

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-',$request->subcategory_name)), 
        ]);

       $notification = array(
            'message' => 'SubCategory Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.subcategory')->with($notification); 

    }
    public function EditSubCategory($id){

        $categories = Category::orderBy('category_name','ASC')->get();
        $subcategory = SubCategory::findOrFail($id);
        return view('backend.subcategory.edit_subcategory',compact('categories','subcategory'));
  
      }// End Method 
  
  
  
      public function UpdateSubCategory(Request $request){
  
          $subcat_id = $request->id;
  
           SubCategory::findOrFail($subcat_id)->update([
              'category_id' => $request->category_id,
              'subcategory_name' => $request->subcategory_name,
              'subcategory_slug' => strtolower(str_replace(' ', '-',$request->subcategory_name)), 
          ]);
  
         $notification = array(
              'message' => 'SubCategory Updated Successfully',
              'alert-type' => 'success'
          );
  
          return redirect()->route('all.subcategory')->with($notification); 
  
  
      }// End Method 
  
  
      public function DeleteSubCategory($id){
  
          SubCategory::findOrFail($id)->delete();
  
           $notification = array(
              'message' => 'SubCategory Deleted Successfully',
              'alert-type' => 'success'
          );
  
          return redirect()->back()->with($notification); 
  
  
        }  




}