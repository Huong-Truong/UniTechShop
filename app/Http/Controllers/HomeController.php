<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();


class HomeController extends Controller
{
    public function index(){
       return view('pages.home');
    }

    public function login(){
        return view('login');
    }
}
