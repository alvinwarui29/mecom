<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //get request
    public function AdminDashboard(){
        return view('admin.admin_dashboard');
    }
}
