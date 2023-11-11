<?php

use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\frontend\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\CompareController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

 // Compare All Route 
 Route::controller(CompareController::class)->group(function(){
    Route::get('/compare' , 'AllCompare')->name('compare');
    Route::get('/get-compare-product' , 'GetCompareProduct');
    Route::get('/compare-remove/{id}' , 'CompareRemove'); 

}); 


Route::get('/', [IndexController::class, 'Index']);
Route::get('/product/details/{id}/{slug}', [IndexController::class, 'ProductDetails']);
Route::get('/vendor/details/{id}', [IndexController::class, 'VendorDetails'])->name('vendor.details');
Route::get('/vendor/all', [IndexController::class, 'VendorAll'])->name('vendor.all');
Route::get('/product/subcategory/{id}/{slug}', [IndexController::class, 'SubCatWiseProduct']);
Route::get('/product/category/{id}/{slug}', [IndexController::class, 'CatWiseProduct']);
Route::get('/product/view/modal/{id}', [IndexController::class, 'ProductViewAjax']);

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->middleware(RedirectIfAuthenticated::class);
Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);
Route::get('/become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/vendor/register', [VendorController::class, 'VendorRegister'])->name('vendor.register');

//Indexcontroller

Route::get('/products/details/{id}/{slug}' ,[IndexController::class ,'ProductDetails']);
Route::get('/product/details/{id}/{slug}' ,[IndexController::class ,'ProductDetails']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//admin middleware
Route::middleware(['auth','role:admin'])->group(function () {

    Route::get("/admin/dashboard",[AdminController::class,'AdminDashboard'])->name('admin.dashboard');
    Route::get("/admin/logout",[AdminController::class,'AdminDestroy'])->name('admin.logout');
    Route::get("/admin/profile",[AdminController::class,'AdminProfile'])->name('admin.profile');
    Route::get("/admin/change/password",[AdminController::class,'AdminChangePassword'])->name('admin.change.password');
    Route::post("/admin/profile/store",[AdminController::class,'AdminProfileStore'])->name('admin.profile.store');
    Route::post("/admin/update/password",[AdminController::class,'AdminUpdatePass'])->name('change.password');
});

//vendor middleware
Route::middleware(['auth','role:vendor'])->group(function () {

    Route::get("/vendor/dashboard",[VendorController::class,'vendorDashboard'])->name('vendor.dashboard');
    Route::get("/vendor/logout",[VendorController::class,'VendorDestroy'])->name('vendor.logout');
    Route::get("/vendor/profile",[VendorController::class,'VendorProfile'])->name('vendor.profile');
    Route::get("/vendor/change/password",[VendorController::class,'VendorchangePass'])->name('vendor.change.password');
    Route::post("/vendor/profile/store",[VendorController::class,'VendorProfileStore'])->name('vendor.profile.store');
    Route::post("/vendor/update/password",[VendorController::class,'VendorUpdatePass'])->name('vendor.update.password');

    Route::controller(VendorProductController::class)->group(function(){
        Route::get('/vendor/all/product' , 'VendorAllProduct')->name('vendor.all.product');
        Route::get('/vendor/add/product' , 'VendorAddProduct')->name('vendor.add.product');
        Route::get('/vendor/subcategory/ajax/{category_id}' , 'VendorGetSubCategory');
        Route::post('/vendor/store/product' , 'VendorStoreProduct')->name('vendor.store.product');
        Route::get('/vendor/edit/product/{id}' , 'VendorEditProduct')->name('vendor.edit.product');
        Route::post('/vendor/update/product' , 'VendorUpdateProduct')->name('vendor.update.product');
        Route::post('/vendor/update/product/thambnail' , 'VendorUpdateProductThabnail')->name('vendor.update.product.thambnail');
        Route::post('/vendor/update/product/multiimage' , 'VendorUpdateProductmultiImage')->name('vendor.update.product.multiimage');
        Route::get('/vendor/product/multiimg/delete/{id}' , 'VendorMultiimgDelete')->name('vendor.product.multiimg.delete');
        Route::get('/vendor/product/inactive/{id}' , 'VendorProductInactive')->name('vendor.product.inactive');
        Route::get('/vendor/product/active/{id}' , 'VendorProductActive')->name('vendor.product.active');
        Route::get('/vendor/delete/product/{id}' , 'VendorProductDelete')->name('vendor.delete.product');


    });
    
});


//user middleware
Route::middleware(['auth'])->group(function() {
    
    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
    Route::get('/user/logout', [UserController::class, 'UserDestroy'])->name('user.logout');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::post('/user/update/password', [UserController::class, 'UserUpdatePass'])->name('user.update.password');
    
    });




Route::middleware(['auth','role:admin'])->group(function() {

    ///brand controller all routes
Route::controller(BrandController::class)->group(function (){
    Route::get('/all/brand' , 'AllBrand')->name('all.brand');
    Route::get('/add/brand' , 'AddBrand')->name('add.brand');
    Route::get('/edit/brand/{id}' , 'EditBrand')->name('edit.brand');
    Route::get('/delete/brand/{id}' , 'DeleteBrand')->name('delete.brand');
    Route::post('/store/brand' , 'StoreBrand')->name('brand.store');
    Route::post('/update/brand' , 'UpdateBrand')->name('update.brand');
});

//category all routes
Route::controller(CategoryController::class)->group(function (){
    Route::get('/all/category' , 'AllCategory')->name('all.category');
    Route::get('/add/category' , 'AddCategory')->name('add.category');
    Route::get('/edit/category/{id}' , 'EditCategory')->name('edit.category');
    Route::get('/delete/Category/{id}' , 'DeleteCategory')->name('delete.category');
     Route::post('/store/category' , 'StoreCategory')->name('store.category');
    Route::post('/update/category' , 'UpdateCategory')->name('update.category');
});

 // subCategory All Route 
 Route::controller(SubCategoryController::class)->group(function(){
    Route::get('/all/subcategory' , 'AllSubCategory')->name('all.subcategory');
    Route::get('/add/subcategory' , 'AddSubCategory')->name('add.subcategory');
    Route::post('/store/subcategory' , 'StoreSubCategory')->name('store.subcategory');
    Route::get('/edit/subcategory/{id}' , 'EditSubCategory')->name('edit.subcategory');
    Route::post('/update/subcategory' , 'UpdateSubCategory')->name('update.subcategory');
    Route::get('/delete/subcategory/{id}' , 'DeleteSubCategory')->name('delete.subcategory');
    Route::get('/subcategory/ajax/{category_id}' , 'GetSubCategory');
});

//Admin contorller
Route::controller(AdminController::class)->group(function () {

    Route::get("/inactive/vendor",'InactiveVendor')->name('inactive.vendor');
    Route::get("/active/vendor",'ActiveVendor')->name('active.vendor');
    Route::get('/inactive/vendor/details/{id}' , 'InactiveVendorDetails')->name('inactive.vendor.details');
    Route::get('/active/vendor/details/{id}' , 'ActiveVendorDetails')->name('active.vendor.details');
    Route::post('/activate/vendor' , 'ActivateIncativeVvendor')->name('activate.inactive.vendor');
    Route::post('/inactivate/vendor' , 'InActivateactiveVvendor')->name('inactivate.active.vendor');

});


//Product controller routes
Route::controller(ProductController::class)->group(function(){
    Route::get('/all/product' , 'AllProduct')->name('all.product');
    Route::get('/add/product' , 'AddProduct')->name('add.product');
    Route::post('/store/product' , 'StoreProduct')->name('store.product');
    Route::get('/edit/product/{id}' , 'EditProduct')->name('edit.product');
    Route::post('/update/product' , 'UpdateProduct')->name('update.product');
    Route::post('/update/product/thambnail' , 'UpdateProductThambnail')->name('update.product.thambnail');
    Route::post('/update/product/multiimage' , 'UpdateProductMultiimage')->name('update.product.multiimage');
    Route::get('/product/multiimg/delete/{id}' , 'MulitImageDelelte')->name('product.multiimg.delete');
    Route::get('/product/inactive/{id}' , 'ProductInactive')->name('product.inactive');
    Route::get('/product/active/{id}' , 'ProductActive')->name('product.active');
    Route::get('/delete/product/{id}' , 'ProductDelete')->name('delete.product');
});
//slider controller routes
Route::controller(SliderController::class)->group(function(){
    Route::get('/all/slider' , 'AllSlider')->name('all.slider');
    Route::get('/add/slider' , 'AddSlider')->name('add.slider');
    Route::post('/store/slider' , 'StoreSlider')->name('store.slider');
    Route::get('/edit/slider/{id}' , 'EditSlider')->name('edit.slider');
    Route::post('/update/slider' , 'UpdateSlider')->name('update.slider');
    Route::get('/delete/slider/{id}' , 'DeleteSlider')->name('delete.slider');


});
Route::controller(BannerController::class)->group(function(){
    Route::get('/all/banner' , 'AllBanner')->name('all.banner');
    Route::get('/add/banner' , 'addBanner')->name('add.banner');
    Route::get('/add/banner' , 'AddBanner')->name('add.banner');
    Route::post('/store/banner' , 'StoreBanner')->name('store.banner');
    Route::get('/edit/banner/{id}' , 'EditBanner')->name('edit.banner');
    Route::post('/update/banner' , 'UpdateBanner')->name('update.banner');
    Route::get('/delete/banner/{id}' , 'DeleteBanner')->name('delete.banner');

});
}); // End Middleware 


//Cart category
Route::controller(CartController::class)->group(function(){
    Route::post('/cart/data/store/{id}','AddToCart')->name('cart.data.store');
    Route::get('/product/mini/cart','MiniCart');
    Route::get('/minicart/product/remove/{rowId}','RemoveMiniCart');
});
Route::post('/add-to-compare/{product_id}', [CompareController::class, 'AddToCompare']);

Route::middleware(['auth','role:user'])->group(function() {
    
    // Wishlist All Route 
    Route::controller(WishlistController::class)->group(function(){
        Route::get('/wishlist' , 'AllWishlist')->name('wishlist');
        Route::post('/add-to-wishlist/{product_id}', 'AddToWishList');
        Route::get('/get-wishlist-product' , 'GetWishlistProduct');
        Route::get('/wishlist-remove/{id}' , 'WishlistRemove');
   
   
   }); 
   
   
   }); // end group middleware