<?php

namespace App\Http\Controllers;
use App\Models\NhaCungCap;
use App\Models\Product;
use App\Models\BaoHanh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();

class NhaCungCapController extends Controller
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
    public function add_nhacungcap ()
    {
        $this->AuthenLogin();
        return view('admin.nhaphang.add_nhacungcap');
    }
    public function save_nhacungcap(Request $request)    
    {
        $this->AuthenLogin();
        $data = $request->all();
        $nccap = new NhaCungCap();
        $nccap->nhacungcap_ten = $data['ncc_ten'];
        $nccap->nhacungcap_email = $data['ncc_mail'];
        $nccap->nhacungcap_diachi = $data['ncc_diachi'];
        $nccap->nhacungcap_sdt = $data['ncc_sdt'];

     
        if((int) $data['ncc_sdt'] == 0){
            Session::put('message','Số điện thoại không hợp lệ');
            return view('admin.nhaphang.add_nhacungcap');
        }
        else {
            
            $nccap->save();
            return Redirect::to('all-nhacungcap'); 
         }
        }
      
            
       
       
    
    public function all_nhacungcap(){
        $this->AuthenLogin();
        $all_nhacungcap = NhaCungCap::orderBy('nhacungcap_id','desc')->get();
        $manger_nhacungcap = view ('admin.nhaphang.all_nhacungcap')->with('all_nhacungcap', $all_nhacungcap);
        return view('admin_layout')->with('admin.all_nhacungcap',$manger_nhacungcap); ## gom lại hiện chung
    }
    public function edit_nhacungcap($nhacungcap_id){
        $this->AuthenLogin();
        $nhacungcap = NhaCungCap::where('nhacungcap_id', $nhacungcap_id)->get();
       //  $nhacungcap = DB::table('phanloaisp')->where('phanloai_id', $nhacungcap_id)->get();
        $manger_nhacungcap = view ('admin.nhaphang.edit_nhacungcap')->with('edit_nhacungcap', $nhacungcap);
        return view('admin_layout')->with('admin.nhaphang.edit_nhacungcap',$manger_nhacungcap); ## gom lại hiện chung
    }
    public function update_nhacungcap(Request $request,$nhacungcap_id){
        $this->AuthenLogin();
        $nhacungcap = NhaCungCap::find( $nhacungcap_id );
        $data = $request->all();
        if((int) $data['nhacungcap_sdt'] == 0){
            Session::put('message','Số điện thoại không hợp lệ');
            return view('admin.nhaphang.add_nhacungcap');
        }
        $nhacungcap->nhacungcap_ten = $data['nhacungcap_ten'];
        $nhacungcap->nhacungcap_sdt = $data['nhacungcap_sdt'];
        $nhacungcap->nhacungcap_email = $data['nhacungcap_email'];
        $nhacungcap->nhacungcap_diachi = $data['nhacungcap_diachi'];
       // DB::table('phanloaisp')->where('phanloai_id', $nhacungcap_id)->update($data);
         $nhacungcap->save();
        Session::put('message','Cập nhật thông tin thành công');
        return Redirect::to('all-nhacungcap'); 
    }

    public function delete_nhacungcap($nhacungcap_id){
        $this->AuthenLogin();
        $count = DB::table('hoadonnhap')->where('nhacungcap_id',$nhacungcap_id)->count();
        $check = DB::table('hoadonnhap')->where('nhacungcap_id',$nhacungcap_id)->first();
        if($check){
            Session::put('message','Không thể xóa. Đang có '.$count.' hóa đơn nhập của nhà cung cấp này');
            return Redirect::to('all-nhacungcap'); 
        }
        $nhacungcap = NhaCungCap::find($nhacungcap_id);
        $nhacungcap->delete();
        Session::put('message','Cập nhật nhà cung cấp sản thành công');
        return Redirect::to('all-nhacungcap'); 
    }
}
