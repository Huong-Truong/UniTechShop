<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();


class ProductController extends Controller
{
    
    public function AuthenLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return  Redirect::to('admin.dashboard');
        }else{
           return Redirect::to('admin')->send(); ## hàm send() có thể không cần thiết
        }
    }
    public function add_product ()
    {
        $this->AuthenLogin();
        $cate_product = DB::table('danhmuc')->orderby('danhmuc_id', 'desc')->get(); ## lấy id 
        $brand_product = DB::table('hangsanpham')->orderby('hang_id', 'desc')->get(); ## lấy id 
       return view ('admin.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
 
    }

    public function all_product ()
    {
        $this->AuthenLogin();
        $all = DB::table('product')
        ->join('category', 'category.category_id', '=', 'product.category_id')
        ->join('brand', 'brand.brand_id', '=', 'product.brand_id')
        ->get(); // Thêm phương thức get() để lấy tất cả dữ liệu
    
        $manger = view ('admin.all_product')->with('all', $all);
        return view('admin_layout')->with('admin.all_product',$manger); ## gom lại hiện chung

    }

    public function save_product (Request $request)    
    {
        $this->AuthenLogin();
        $data = array();
        $data['sanpham_ten'] = $request->product_name;
        $data['danhmuc_id'] = $request->category;
        $data['hang_id'] = $request->brand;
        $data['sanpham_mota'] = $request->product_content;
        $data['sanpham_gia'] = $request->product_price;
        // $data['product_imgage'] = $request->product_image;
        $data['sanpham_trangthai'] = $request->product_status;
        $get_image_file = $request->file('product_image');


        if($get_image_file){
            // Lấy tên tệp tin gốc và loại bỏ phần mở rộng
            $get_name_image = current(explode('.', $get_image_file->getClientOriginalName()));
            
            // Tạo tên mới cho ảnh với phần mở rộng gốc và số ngẫu nhiên
            $new_image = $get_name_image.rand(0, 99).'.'.$get_image_file->getClientOriginalExtension();
            
            // Di chuyển tệp tin đến thư mục đích
            $get_image_file->move('upload/product', $new_image);
            
            // Lưu thông tin ảnh vào cơ sở dữ liệu
            $data['sanpham_hinhanh'] = $new_image;
            DB::table('sanpham')->insert($data);
            
            // Hiển thị thông báo thành công và chuyển hướng
            Session::put('message', 'Thêm sản phẩm mới thành công!');
            return Redirect::to('add-product');
        }else{
                        
            DB::table('sanpham')->insert($data);
            
            // Hiển thị thông báo thành công và chuyển hướng
            Session::put('message', 'Thêm sản phẩm mới thành công!');
            return Redirect::to('add-product');
        }

        

        /*
            $data['product_name'] : tên của cột trong database
            $request->product_product_name: tên của name lấy bên save
        */
        /*insert vào bảng*/
       
    }


    public function unactive_product($product_id){
        $this->AuthenLogin();
        DB::table('product')->where('product_id', $product_id)->update(['product_status' => 0]);
        Session::put('message','Cập nhật hiển thị thành công');
        return Redirect::to('all-product'); 
    }

    public function active_product($product_id){
        $this->AuthenLogin();
        DB::table('product')->where('product_id', $product_id)->update(['product_status' => 1]);
        Session::put('message','Cập nhật hiển thị thành công');
        return Redirect::to('all-product'); 
    }

    public function edit_product($product_id)
{
    $this->AuthenLogin();
    $cate_product = DB::table('category')->orderBy('category_id', 'desc')->get();
    $brd_product = DB::table('brand')->orderBy('brand_id', 'desc')->get();
    $product = DB::table('product')->where('product_id', $product_id)->first();
    return view('admin.edit_product')
        ->with('edit_product', $product)
        ->with('cate_product', $cate_product)
        ->with('brand_product', $brd_product);
}



    public function delete_product($product_id){
        $this->AuthenLogin();
        DB::table('product')->where('product_id', $product_id)->delete();
        Session::put('message','Xóa sản phẩm thành công');
        return Redirect::to('all-product'); 
    }

    public function update_product(Request $request, $product_id)
    {
        $this->AuthenLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->category;
        $data['brand_id'] = $request->brand;
        $product = DB::table('product')->where('product_id', $product_id)->first();
        $get_image_file = $request->file('product_image');

        if($get_image_file){
            $get_name_image = current(explode('.', $get_image_file->getClientOriginalName()));
            $new_image = $get_name_image.rand(0, 99).'.'.$get_image_file->getClientOriginalExtension();
            $get_image_file->move('upload/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('product')->where('product_id', $product_id)->update($data);
            Session::put('message', 'Cập nhật sản phẩm thành công!');
            return Redirect::to('all-product');
        }
            
        DB::table('product')->where('product_id', $product_id)->update($data);
        Session::put('message', 'Cập nhật sản phẩm thành công!');
      
        return Redirect::to('all-product');
    }
    
    // end admin


    public function show_details_product($product_id){
        $cate_product = DB::table('category')->where('category_status', 1)->orderby('category_id', 'desc')->get(); ## lấy id category
        $brd_product = DB::table('brand')->where('brand_status', 1)->orderby('brand_id', 'desc')->get(); ## lấy id category
      
        $details_product = DB::table('product')
        ->join('category', 'category.category_id', '=', 'product.category_id')
        ->join('brand', 'brand.brand_id', '=', 'product.brand_id')
        ->where('product.product_id', $product_id)->first();

      
         $category_id = $details_product->category_id;
    
        $relate_product = DB::table('product')
        ->join('category', 'category.category_id', '=', 'product.category_id')
        ->join('brand', 'brand.brand_id', '=', 'product.brand_id')
        ->where('product.category_id', $category_id)->whereNotIn('product.product_id', [$product_id] )->get();
                                                                                                ## phải có mảng

        return view('pages.product.show_details')->with('relate', $relate_product)->with('product', $details_product)->with('category', $cate_product)->with('brand', $brd_product);
    }
}
