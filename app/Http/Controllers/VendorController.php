<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorController extends Controller
{
    //get home request
    public function VendorDashboard(){
        return view('vendor.vendor_dashboard');
    }
}
