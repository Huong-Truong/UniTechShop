<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();

class CustomerController extends Controller
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

    public function all_customer()
    {
        $this->AuthenLogin();
        $trangthai = 1;
        $month=0;
        $year=date('Y');

        $all_customer = Customer::leftJoin('donhang', 'khachhang.khachhang_id', '=', 'donhang.khachhang_id')
        ->select(
            'khachhang.khachhang_id',
            'khachhang.khachhang_sdt',
            'khachhang.khachhang_ten',
            'khachhang.khachhang_email',
            'khachhang.khachhang_diachi',
            'khachhang.khachhang_trangthai',
            DB::raw('count(donhang.donhang_id) as total'),
            DB::raw('sum(donhang.donhang_tongtien) as total_amount')
        )
        ->groupBy(
            'khachhang.khachhang_id',
            'khachhang.khachhang_sdt',
            'khachhang.khachhang_ten',
            'khachhang.khachhang_email',
            'khachhang.khachhang_diachi',
            'khachhang.khachhang_trangthai'
        )
        ->orderBy('total', 'desc')
        ->get();

        $manger_customer = view ('admin.customer.all_customer')
        ->with('y',$year)
        ->with('m',$month)
        ->with('t',$trangthai) 
        ->with('all_customer', $all_customer);
        return view('admin_layout')->with('admin.customer.all_customer',$manger_customer); ## gom lại hiện chung

    }

    public function edit_customer($customer_id){
        $this->AuthenLogin();
        $customer = Customer::where('khachhang_id',$customer_id)->get();  
        $manger_customer = view ('admin.customer.edit_customer')->with('edit_customer', $customer);
        return view('admin_layout')->with('admin.customer.edit_customer',$manger_customer); ## gom lại hiện chung
    }


    public function delete_customer($customer_id){
        $this->AuthenLogin();
        if(  $customer = Customer::find( $customer_id )){
            $customer->delete();
            Session::put('message','Xóa khách hàng thành công');
        }

        return Redirect::to('all-customer'); 
    }

    public function update_customer(Request $request,$customer_id){
        $this->AuthenLogin();
       if(  $customer = Customer::find( $customer_id )){
        $data = $request->all();
        $customer->khachhang_ten = $data['khachhang_ten'];
        $customer->khachhang_sdt = $data['khachhang_sdt'];
        $customer->khachhang_email = $data['khachhang_email'];
        $customer->khachhang_diachi = $data['khachhang_diachi'];
     
         $customer->save();
        Session::put('message','Cập nhật thông tin khách hàng thành công');
       }
       else{
        Session::put('message','Cập nhật thông tin khách hàng thất bại');
       }
    
        return Redirect::to('all-customer'); 
    }

    
    public function unactive_customer($customer_id){
        $this->AuthenLogin();
        DB::table('khachhang')->where('khachhang_id', $customer_id)->update(['khachhang_trangthai' => 0]);

       // Session::put('message','Cập nhật hiển thị thành công');
        return Redirect::to('all-customer'); 
    }

    public function active_customer($customer_id){
        $this->AuthenLogin();
        DB::table('khachhang')->where('khachhang_id', $customer_id)->update(['khachhang_trangthai' => 1]);

        //Session::put('message','Cập nhật hiển thị thành công');
        return Redirect::to('all-customer'); 
    }

    public function loc_khachhang(Request $request) {
        $this->AuthenLogin();
        $trangthai = $request->trangthai;
        $month = $request->month;
        $year = $request->year;
    
        if ($trangthai) {
            $tt = $trangthai == 1 ? 'total' : 'total_amount';
    
            $query = Customer::leftJoin('donhang', 'khachhang.khachhang_id', '=', 'donhang.khachhang_id')
                ->select(
                    'khachhang.khachhang_id',
                    'khachhang.khachhang_sdt',
                    'khachhang.khachhang_ten',
                    'khachhang.khachhang_email',
                    'khachhang.khachhang_diachi',
                    'khachhang.khachhang_trangthai',
                    DB::raw('count(donhang.donhang_id) as total'),
                    DB::raw('sum(donhang.donhang_tongtien) as total_amount')
                )
                ->groupBy(
                    'khachhang.khachhang_id',
                    'khachhang.khachhang_sdt',
                    'khachhang.khachhang_ten',
                    'khachhang.khachhang_email',
                    'khachhang.khachhang_diachi',
                    'khachhang.khachhang_trangthai'
                )
                ->orderBy($tt, 'desc');
    
            if ($year) {
                $query->whereYear('donhang.donhang_ngaytao', $year);
            }
    
            if ($month) {
                $query->whereMonth('donhang.donhang_ngaytao', $month);
            }
    
            $all_customer = $query->get();
    
            $manger_customer = view('admin.customer.all_customer')
            ->with('all_customer', $all_customer)
            ->with('y',$year)
            ->with('m',$month)
            ->with('t',$trangthai)   ;
            return view('admin_layout')->with('admin.customer.all_customer', $manger_customer);
        } else {
            return Redirect::to("/all-customer");
        }
    }

}
