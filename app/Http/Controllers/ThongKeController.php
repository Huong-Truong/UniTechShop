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

class ThongKeController extends Controller
{
    //
    
    public function AuthenLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return  Redirect::to('admin.dashboard');
        }else{
           return Redirect::to('admin')->send(); ## hàm send() có thể không cần thiết
        }
    }


    
    function getDaysInMonth($month, $year) {
        $daysInMonth = [];
            // Tạo mảng chứa tất cả các ngày trong tháng
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        
    for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
        $daysInMonth[$date->format('d')] = 0;
    }
    
        return $daysInMonth;
    }

    public function thongke_donhang(){
        $this->AuthenLogin();
        $year = 2025;
        $month = 2;
        
        $soluong = $this->getDaysInMonth($month,$year);
       
        // Lấy dữ liệu đơn hàng từ cơ sở dữ liệu
        $orders = DB::table('donhang')->selectRaw('DAY(donhang_ngaytao) as date, COUNT(*) as count')
        ->whereYear('donhang_ngaytao', $year)
        ->whereMonth('donhang_ngaytao', $month)
        ->groupBy('date')
        ->get();
    
         foreach ($orders as $order) {
            $soluong[$order->date] = $order->count;
        }
        
        return view('admin.thongke.thongkedonhang', compact('soluong'));
        
    }

}
