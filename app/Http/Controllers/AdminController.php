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
    // Đơn hàng
    $year = date('Y');
    $month = date('m');
    $soluongdon = DB::table('donhang')
        ->whereYear('donhang_ngaytao', $year)
        ->whereMonth('donhang_ngaytao', $month)
        ->count('donhang_id');

    // PTTT
    $paymentData = DB::table('donhang')
        ->join('thanhtoan', 'donhang.thanhtoan_id', '=', 'thanhtoan.pttt_id')
        ->select('thanhtoan.pttt_ten', DB::raw('COUNT(donhang.donhang_id) as count'))
        ->groupBy('thanhtoan.pttt_ten')
        ->get();

    // Hãng
    $brandData = DB::table('sanpham')
        ->join('hangsanpham', 'sanpham.hang_id', '=', 'hangsanpham.hang_id')
        ->select('hangsanpham.hang_ten', DB::raw('COUNT(sanpham.sanpham_id) as count'))
        ->groupBy('hangsanpham.hang_ten')
        ->get();

    // Danh mục 
    $categoryData = DB::table('sanpham')
        ->join('danhmuc', 'sanpham.danhmuc_id', '=', 'danhmuc.danhmuc_id')
        ->select('danhmuc.danhmuc_ten', DB::raw('COUNT(sanpham.sanpham_id) as count'))
        ->groupBy('danhmuc.danhmuc_ten')
        ->get();

    // Số lượng đơn hàng theo tháng
    $monthlySalesData = DB::table('donhang')
        ->selectRaw('MONTH(donhang_ngaytao) as month, COUNT(*) as count')
        ->whereYear('donhang_ngaytao', $year)
        ->groupBy('month')
        ->get();

    // Top 10 sản phẩm bán chạy nhất
    $topProductsData = DB::table('chitietdonhang')
    ->join('sanpham', 'sanpham.sanpham_id', '=', 'chitietdonhang.sanpham_id')
    ->select('sanpham.sanpham_ten',DB::raw('COUNT(chitietdonhang.ctdh_soluong) as count'))
    ->groupBy('sanpham.sanpham_ten')
    ->limit(10)
    ->get();
    // Top khách
    $topCustomersData = DB::table('khachhang')
    ->join('donhang', 'khachhang.khachhang_id', '=', 'donhang.khachhang_id')
    ->select('khachhang.khachhang_ten', DB::raw('SUM(donhang.donhang_tongtien) as count'))
    ->groupBy('khachhang.khachhang_ten')
    ->orderBy('count', 'desc')
    ->limit(10)
    ->get();

    return view('admin.dashboard', compact('paymentData', 
    'brandData', 'categoryData', 'monthlySalesData', 'topProductsData','topCustomersData'));
}

    public function dashboard(Request $request)
{
   
    $admin_email = $request->admin_email;
    $admin_password = $request->admin_password;
    $admin_password_md5 = md5($request->admin_password);

    $result = DB::table('admin')->where('admin_email', $admin_email)
    ->where('admin_password', $admin_password)
    ->orWhere('admin_password', $admin_password_md5)
    ->first();
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
