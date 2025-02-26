<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\BaoHanh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();

class BaoHanhController extends Controller
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
    public function add_baohanh ()
    {
        $this->AuthenLogin();
        return view('admin.baohanh.add_baohanh');
    }
    public function save_baohanh(Request $request)    
    {
        $this->AuthenLogin();
        $data = $request->all();
        $baohanh = new BaoHanh();
        $date = $data['date_bh'];
        $baohanh->baohanh_mota = $data['bh_mota'];
     
        if((int)$date == 0){
            Session::put('message','Thời gian nhập vào phải là số');
            return view('admin.baohanh.add_baohanh');
        }
        else {
            $baohanh->baohanh_thoigian = $date.' Tháng';
            $baohanh->save();
            return Redirect::to('all-baohanh'); 
         }
        }
      
            
       
       
    
    public function all_baohanh(){
        $this->AuthenLogin();
        $all_baohanh = BaoHanh::orderBy('baohanh_id','desc')->get();
        $manger_baohanh = view ('admin.baohanh.all_baohanh')->with('all_baohanh', $all_baohanh);
        return view('admin_layout')->with('admin.all_baohanh',$manger_baohanh); ## gom lại hiện chung
    }

    public function delete_baohanh($baohanh_id){
        $this->AuthenLogin();
        $baohanh = BaoHanh::find($baohanh_id);
        $baohanh->delete();
        return Redirect::to('all-baohanh'); 
    }
}
