<?php

namespace App\Http\Controllers;
use Mail;
use App\Mail\ThongBaoViPham;
use App\Models\DanhGia;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();
class DanhGiaController extends Controller
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

        public function show_dg(Request $request,$product_id,$xephang){
            $this->AuthenLogin();
            $product = Product::find($product_id);
          
            $sao = $request->sao ;
            if($xephang == 'all'){
                if($sao == 'all'){
                    return Redirect('/show-dg/'.$product_id.'/'.$xephang);
                }
                if($sao){
                    $dg = DanhGia::join('sanpham','danhgia.sanpham_id','=','sanpham.sanpham_id')
                    ->join('khachhang','khachhang.khachhang_id','=','danhgia.khachhang_id')
                    ->where('sanpham.sanpham_id',$product_id)
                    ->where('danhgia.dg_xephang',$sao)->get();
                }
                else{
                    $dg = DanhGia::join('sanpham','danhgia.sanpham_id','=','sanpham.sanpham_id')
                    ->join('khachhang','khachhang.khachhang_id','=','danhgia.khachhang_id')
                    ->where('sanpham.sanpham_id',$product_id)->get();
                }
              
            }
            else {
                Session::put('message', 'Đã xảy ra lỗi');
                return Redirect('/dashboard');
            }
            
          
            return view('admin.danhgia.show_dg')
            ->with('dg',$dg)
            ->with('product',$product)
            ->with('sao',$sao);
        }

        public function delete_dg($dg_id) {
            $this->AuthenLogin();


            $dg = DanhGia::join('khachhang', 'khachhang.khachhang_id', '=', 'danhgia.khachhang_id')
            ->where('danhgia.dg_id', $dg_id)->first();

            $ten = $dg->khachhang_ten;
            $nd = $dg->dg_noidung;
            $ngay = $dg->dg_ngay;

            Session::put('ten', $ten);
            Session::put('nd', $nd);
            Session::put('ngay', $ngay);
            $email = $dg->khachhang_email;
            $new_mail = new ThongBaoViPham();
            Mail::to($email)->send($new_mail);
            Session::put(',message', 'Xóa bình luận thành công');
            return Redirect::to('/all-product');
        }

      

}
