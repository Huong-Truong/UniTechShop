<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Classify;
use App\Models\Product;
use Carbon\Carbon;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();
class AdminController extends Controller
{

    public function AuthenLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return  Redirect::to('admin.dashboard');
        }else{
           return Redirect::to('admin')->send(); ## hàm send() có thể không cần thiết
        }
    }


    public function index()
    {
        $admin_id = Session::get('admin_id');
        
        if($admin_id){
           return Redirect::to('dashboard');
        }else{
            return view('admin_login') ; 
        }
      
    }## không có pages. gì hết vì cùng cấp

    public function showDashboard()
{
   return view('admin.dashboard');
}

    public function dashboard(Request $request)
{
   
    $admin_email = $request->admin_email;
    $admin_password = $request->admin_password;

    $result = DB::table('admin')->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
    if($result){
        Session::put('admin_name', $result->admin_ten);
        Session::put('admin_id', $result->admin_id);
        return Redirect::to('/dashboard');
    }else{
        Session::put('message', 'Mật khẩu hoặc tài khoản không chính xác');
        return Redirect::to('/admin');
    }
}

    public function logout(Request $request)
{
        $this->AuthenLogin();
        Session::put('admin_ten', null);
        Session::put('admin_id', null);
        return view('admin_login');
}

    public function delete_session($name){
        Session::forget($name);
    }

}
