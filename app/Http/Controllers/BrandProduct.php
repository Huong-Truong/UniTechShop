<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();

class BrandProduct extends Controller
{
    
    public function AuthenLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return  Redirect::to('admin.dashboard');
        }else{
           return Redirect::to('admin')->send(); ## hàm send() có thể không cần thiết
        }
    }
    public function add_brand_product ()
    {
        $this->AuthenLogin();
        return view('admin.add_brand_product');
    }

    public function all_brand_product ()
    {
        $this->AuthenLogin();
       $all_brand = DB::table('hangsanpham')->get(); ## lấy tấy cả dữ liêu
        $manger_brand = view ('admin.all_brand_product')->with('all_brand', $all_brand);
        return view('admin_layout')->with('admin.all_brand_product',$manger_brand); ## gom lại hiện chung

    }

    public function save_brand_product (Request $request)    
    {
        $this->AuthenLogin();
        $data = array();
        $data['hang_ten'] = $request->brand_name;
        $data['hang_trangthai'] = $request->brand_status;
        $data['hang_mota'] = $request->brand_content;
        /*
            $data['brand_name'] : tên của cột trong database
            $request->brand_product_name: tên của name lấy bên save_brand
        */
        /*insert vào bảng*/
        DB::table('hangsanpham')->insert($data);
        Session::put('message','Thêm hãng sản phẩm mới thành công!');
        return Redirect::to('add-brand-product'); ## Khi thêm thành công rồi thì trả lại về thêm danh mục sản phẩm
    }


    public function unactive_brand_product($brand_id){
        $this->AuthenLogin();
        DB::table('hangsanpham')->where('hang_id', $brand_id)->update(['hang_trangthai' => 0]);
        Session::put('message','Cập nhật hiển thị thành công');
        return Redirect::to('all-brand-product'); 
    }

    public function active_brand_product($brand_id){
        $this->AuthenLogin();
        DB::table('hangsanpham')->where('hang_id', $brand_id)->update(['hang_trangthai' => 1]);
        Session::put('message','Cập nhật hiển thị thành công');
        return Redirect::to('all-brand-product'); 
    }

    public function edit_brand_product($brand_id){
        $this->AuthenLogin();
        $brand = DB::table('hangsanpham')->where('hang_id', $brand_id)->get();
        $manger_brand = view ('admin.edit_brand_product')->with('edit_brand', $brand);
        return view('admin_layout')->with('admin.edit_brand_product',$manger_brand); ## gom lại hiện chung
    }


    public function delete_brand_product($brand_id){
        $this->AuthenLogin();
        DB::table('hangsanpham')->where('hang_id', $brand_id)->delete();
        Session::put('message','Xóa hãng sản phẩm thành công');
        return Redirect::to('all-brand-product'); 
    }

    public function update_brand_product(Request $request,$brand_id){
        $this->AuthenLogin();
        $data = array();
        $data['hang_ten'] = $request->brand_name;
        $data['hang_mota'] = $request->brand_content;
        DB::table('hangsanpham')->where('hang_id', $brand_id)->update($data);
        Session::put('message','Cập nhật hãng thành công');
        return Redirect::to('all-brand-product'); 
    }

    // end function admin


    public function show_brand_home($brand_id){
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); ## lấy id category
        $brd_product = DB::table('brand')->where('brand_status', 1)->orderby('brand_id', 'desc')->get(); ## lấy id category
        $all = DB::table('product')
        ->join('brand', 'brand.brand_id', '=', 'product.brand_id')
        ->where('product.brand_id', $brand_id)
        ->get(); // Thêm phương thức get() để lấy tất cả dữ liệu
        $brand_name = DB::table('brand')->where('brand_status', 1)->where('brand_id', $brand_id)
        ->pluck('brand_name')->first(); ## thêm first để bỏ dấu [""] khi in
        return view('pages.brand.show_brand')->with('brand_name', $brand_name)->with('danhmuc', $cate_product)->with('brand', $brd_product)->with('brand_id', $all);
    }


    
    public function show_thuonghieu_home($hang_id){
     
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); // lấy id category
        $product = DB::table('sanpham')->where('sanpham_trangthai', 1)->where('hang_id', $hang_id)->orderby('sanpham_id', 'desc')->paginate(12);
        $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        $ten_hang = DB::table('hangsanpham')->where('hang_id', $hang_id)->first();
        return view('pages.brand.show_brand')->with('ten_hang', $ten_hang)->with('danhmuc', $cate_product)->with('sanpham', $product)->with('hang', $brand)->with('phanloai', $phanloai);
   
   
    }
}
