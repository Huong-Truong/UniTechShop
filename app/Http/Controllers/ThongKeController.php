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
    
    // function getMonthsInYear( $year) {
    //     $monthsInYear = [];
    //         // Tạo mảng chứa tất cả các ngày trong tháng
    //     $startDate = Carbon::create($year, 1);
    //     $endDate = $startDate->copy()->endOfMonth();
        
    // for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
    //     $monthsInYear[$date->format('m')] = 0;
    // }
    
    //     return  $monthsInYear;
    // }

    public function thongke_don_thang(Request $request){
        $this->AuthenLogin();

        if($request->trangthai){
            $trangthai = $request->trangthai ;
        }
        else {
            $trangthai = 0;
        }
        
        if($request->month && $request->year){
            $year = $request->year;
            $month = $request->month;
        }
        else {
            $year = date('Y');
            $month = date('m');
        }
        
       
        
        $chart = $this->getDaysInMonth($month,$year);
       
        // Lấy dữ liệu đơn hàng từ cơ sở dữ liệu
        if($trangthai == '0'){
            $orders = DB::table('donhang')
            ->selectRaw('LPAD(DAY(donhang_ngaytao), 2, "0") as date, COUNT(*) as count')
            ->whereYear('donhang_ngaytao', $year)
            ->whereMonth('donhang_ngaytao', $month)
            ->groupBy('date')
            ->get();
            foreach ($orders as $order) {
                $chart[$order->date] = $order->count;
            }
        }
        else{
            $orders = DB::table('donhang')
            ->selectRaw('LPAD(DAY(donhang_ngaytao), 2, "0") as date, SUM(donhang_tongtien) as total_amount')
            ->whereYear('donhang_ngaytao', $year)
            ->whereMonth('donhang_ngaytao', $month)
            ->groupBy('date')
            ->get();
            foreach ($orders as $order) {
                $chart[$order->date] = $order->total_amount;
            }
        }
       
        $soluong = DB::table('donhang')
        ->whereYear('donhang_ngaytao', $year)
        ->whereMonth('donhang_ngaytao', $month)
        ->sum('donhang_id');
        
        
        return view('admin.thongke.thongkedon_thang', compact('chart','year','month','trangthai'));
        
    }

    public function thongke_don_nam(Request $request){
        $this->AuthenLogin();
        
        if($request->trangthai){
            $trangthai = $request->trangthai ;
        }
        else {
            $trangthai = 0;
        }

        if($request->year){
            $year = $request->year;
        }
        else {
            $year = date('Y');
        }
      
       
        $chart = [];
        for($i=01; $i <= 12; $i++){
            $chart[$i] = 0;
        }
       
        if($trangthai == '0'){
            $orders = DB::table('donhang')
            ->selectRaw('MONTH(donhang_ngaytao)  as date, COUNT(*) as count')
            ->whereYear('donhang_ngaytao', $year)
            ->groupBy('date')
            ->get();
            foreach ($orders as $order) {
                $chart[$order->date] = $order->count;
            }
        }
        else{
            $orders = DB::table('donhang')
            ->selectRaw('MONTH(donhang_ngaytao) as date, SUM(donhang_tongtien) as total_amount')
            ->whereYear('donhang_ngaytao', $year)
            ->groupBy('date')
            ->get();
            foreach ($orders as $order) {
                $chart[$order->date] = $order->total_amount;
            }
        }
        
        return view('admin.thongke.thongkedon_nam', compact('chart','year','trangthai'));
        
    }

    public function thongke_sp(Request $request)
    {
        $this->AuthenLogin(); 
        $month = $request->month ?? 0;
        $year = $request->year ?? date('Y');
    
        $query = DB::table('chitietdonhang')
            ->join('sanpham', 'sanpham.sanpham_id', '=', 'chitietdonhang.sanpham_id')
            ->join('donhang', 'donhang.donhang_id', '=', 'chitietdonhang.donhang_id')
            ->select(
                'sanpham.sanpham_id',
                'sanpham.sanpham_ten',
                DB::raw('SUM(chitietdonhang.ctdh_soluong) as ctdh_soluong')
            )
            ->groupBy('sanpham.sanpham_id', 'sanpham.sanpham_ten')
            ->whereYear('donhang.donhang_ngaytao', $year)
            ->orderBy('sanpham.sanpham_id', 'desc');
    
        if ($month) {
            $query->whereMonth('donhang.donhang_ngaytao', $month);
        }
        if($number = $request->number){
            $query->limit($number);
        }
        $products = $query->get();
    
        return view('admin.thongke.thongke_sp')
            ->with('y', $year)
            ->with('m', $month)
            ->with('products', $products);
    }

    public function thongke_kh(Request $request) {
        $this->AuthenLogin(); 
        $m = $request->month ?? 0;
        $y = $request->year ?? date('Y');

        $trangthai = $request->trangthai ?? 1;
        $query = DB::table('donhang')
            ->join('khachhang', 'khachhang.khachhang_id', '=', 'donhang.khachhang_id')
            ->select('khachhang.khachhang_sdt', DB::raw($trangthai == 1 ? 'count(donhang.donhang_id) as total' : 'SUM(donhang.donhang_tongtien) as total'))
            ->groupBy('khachhang.khachhang_sdt')
            ->orderBy('total', 'desc');
    
        if ($request->number) {
            $query->limit($request->number);
        }
        if ($request->year){
            $query->whereYear('donhang_ngaytao', $request->year);
            if($request->month){
                $query->whereMonth('donhang_ngaytao', $request->month);
            }
        }
        $khachhangs = $query->get();
    
        return view('admin.thongke.thongke_kh')
            ->with('khachhangs', $khachhangs)
            ->with('t', $trangthai)
            ->with('y',$y)
            ->with('m',$m);
    }



}

