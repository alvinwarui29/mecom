<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use \Intervention\Image\Facades\Image; 

class CategoryController extends Controller
{
    public function AllCategory(){
        $categories = Category::latest()->get();
        return view('Backend.category.all_category',compact('categories'));
    }// end method


    public function AddCategory(){
        return view('Backend.category.add_category');
    }// end method
    

    public function StoreCategory(Request $req){
        $image = $req->file('category_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(120,120)->save('upload/category/'.$name_gen);
        $save_url = 'upload/category/'.$name_gen;

    Category::insert([
        'category_name' => $req->category_name,
        'category_slug' => strtolower(str_replace(' ', '-',$req->category_name)),
        'category_image' => $save_url, 
    ]);

   $notification = array(
        'message' => 'Category Inserted Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('all.category')->with($notification); 
   }//


   public function EditCategory($id){
        $category = Category::findorfail($id);
        return view('Backend.category.edit_category',compact('category'));
   }//

   public function UpdateCategory(Request $request){
    $category_id = $request->id;
    $old_img = $request->old_image;

    if ($request->file('category_image')) {

    $image = $request->file('category_image');
    $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    Image::make($image)->resize(120,120)->save('upload/category/'.$name_gen);
    $save_url = 'upload/category/'.$name_gen;

    if (file_exists($old_img)) {
       unlink($old_img);
    }

    Category::findOrFail($category_id)->update([
        'category_name' => $request->category_name,
        'category_slug' => strtolower(str_replace(' ', '-',$request->category_name)),
        'category_image' => $save_url, 
    ]);

   $notification = array(
        'message' => 'Category Updated with image Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('all.category')->with($notification); 

    } else {

         Category::findOrFail($category_id)->update([
        'category_name' => $request->category_name,
        'category_slug' => strtolower(str_replace(' ', '-',$request->category_name)), 
    ]);

   $notification = array(
        'message' => 'Category Updated without image Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('all.category')->with($notification); 

    }
   }
   public function DeleteCategory($id){
        $category = Category::findorfail($id);
        $img = $category->category_image;
        unlink($img);
        Category::findorfail($id)->delete();
        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.category')->with($notification);

   }
    
}
