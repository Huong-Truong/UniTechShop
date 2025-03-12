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

         $all_customer = Customer::get();
        $manger_customer = view ('admin.customer.all_customer')->with('all_customer', $all_customer);
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


}
