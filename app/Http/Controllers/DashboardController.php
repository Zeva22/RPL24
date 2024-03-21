<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('backend.content.dashboard');
    }

    public function profile(){
        return view('backend.content.profile');
    }  

    public function resetPassword(){
        return view('backend.content.resetPassword');
    } 
}
