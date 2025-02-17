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
       return view ('admin.product.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
 
    }

    public function all_product ()
    {
        $this->AuthenLogin();
        $all = DB::table('sanpham')
        ->join('danhmuc', 'danhmuc.danhmuc_id', '=', 'sanpham.danhmuc_id')
        ->join('hangsanpham', 'hangsanpham.hang_id', '=', 'sanpham.hang_id')
        ->get(); // Thêm phương thức get() để lấy tất cả dữ liệu
    
        $manger = view ('admin.product.all_product')->with('all', $all);
        return view('admin_layout')->with('admin.product.all_product',$manger); ## gom lại hiện chung

    }

    public function save_product (Request $request)    
    {
        $this->AuthenLogin();
        // Lấy ra id lớn nhất
        $maxId = DB::table('sanpham')->max('sanpham_id') + 1;
       // Bảng HDSD
        $hdsd = array();
        $hdsd['sanpham_id'] = $maxId;
        $hdsd['HDSD_mota'] = 'Chưa có';
        $hdsd['HDSD_video'] = 'Chưa có';
        // Bảng SP
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
           // $get_name_image = current(explode('.', $get_image_file->getClientOriginalName()));
            
            // Tạo tên mới cho ảnh với phần mở rộng gốc và số ngẫu nhiên
            $new_image = str_replace(' ', '', $data['sanpham_ten']).'.'.$get_image_file->getClientOriginalExtension();
            
            // Di chuyển tệp tin đến thư mục đích
            $get_image_file->move('img/sp'.$maxId , $new_image);
            
            // Lưu thông tin ảnh vào cơ sở dữ liệu
            $data['sanpham_hinhanh'] = $new_image;
           // insert vô sanpham
           DB::table('sanpham')->insert($data);
           // insert vô hdsd
           DB::table('hdsd')->insert($hdsd);
            // Hiển thị thông báo thành công và chuyển hướng
            Session::put('message', 'Thêm sản phẩm mới thành công!');
            return Redirect::to('all-product');
        }else{
            // insert vô sanpham
            DB::table('sanpham')->insert($data);
            // insert vô hdsd
            DB::table('hdsd')->insert($hdsd);
            // Hiển thị thông báo thành công và chuyển hướng
            Session::put('message', 'Thêm sản phẩm mới thành công!');
            return Redirect::to('all-product');
        }

        

        /*
            $data['product_name'] : tên của cột trong database
            $request->product_product_name: tên của name lấy bên save
        */
        /*insert vào bảng*/
       
    }


    public function unactive_product($product_id){
        $this->AuthenLogin();
        DB::table('sanpham')->where('sanpham_id', $product_id)->update(['sanpham_trangthai' => 0]);
        // Session::put('message','Cập nhật hiển thị thành công');
        return Redirect::to('all-product'); 
    }

    public function active_product($product_id){
        $this->AuthenLogin();
        DB::table('sanpham')->where('sanpham_id', $product_id)->update(['sanpham_trangthai' => 1]);
        // Session::put('message','Cập nhật hiển thị thành công');
        return Redirect::to('all-product'); 
    }

    public function edit_product($product_id)
{
    $this->AuthenLogin();
    $cate_product = DB::table('danhmuc')->orderBy('danhmuc_id', 'desc')->get();
    $brd_product = DB::table('hangsanpham')->orderBy('hang_id', 'desc')->get();
    $product = DB::table('sanpham')->where('sanpham_id', $product_id)->first();
    return view('admin.product.edit_product')
        ->with('edit_product', $product)
        ->with('cate_product', $cate_product)
        ->with('brand_product', $brd_product);
}



    public function delete_product($product_id){
        $this->AuthenLogin();
        DB::table('sanpham')->where('sanpham_id', $product_id)->delete();
        Session::put('message','Xóa sản phẩm thành công');
        return Redirect::to('all-product'); 
    }

    public function update_product(Request $request, $product_id)
    {
        $this->AuthenLogin();
        $data = array();
        $data['sanpham_ten'] = $request->product_name;
        $data['sanpham_gia'] = $request->product_price;
        $data['sanpham_mota'] = $request->product_content;
        $data['danhmuc_id'] = $request->category;
        $data['hang_id'] = $request->brand;
        $product = DB::table('sanpham')->where('sanpham_id', $product_id)->first();
        $get_image_file = $request->file('product_image');

       
        if($get_image_file){
            // Lấy tên tệp tin gốc và loại bỏ phần mở rộng
           // $get_name_image = current(explode('.', $get_image_file->getClientOriginalName()));
            
            // Tạo tên mới cho ảnh với phần mở rộng gốc và số ngẫu nhiên
            $new_image = str_replace(' ', '', $data['sanpham_ten']).'.'.$get_image_file->getClientOriginalExtension();
            
            // Di chuyển tệp tin đến thư mục đích
            $get_image_file->move('img/sp'.$product_id, $new_image);
            
            // Lưu thông tin ảnh vào cơ sở dữ liệu
            $data['sanpham_hinhanh'] = $new_image;
            
        }
            
        DB::table('sanpham')->where('sanpham_id', $product_id)->update($data);
        Session::put('message', 'Cập nhật sản phẩm thành công!');
      
        return Redirect::to('all-product');
    }
    // Hàm hdsd
    
    public function edit_hdsd_product($product_id)
{
    $this->AuthenLogin();
    $product = DB::table('sanpham')->where('sanpham_id',$product_id)->get();
    $hdsd = DB::table('hdsd')->where('sanpham_id', $product_id)->get();
    return view('admin.product.edit_hdsd_product')
        ->with('hdsd', $hdsd)
        ->with('product', $product);
}

public function update_hdsd_product(Request $request,$product_id){
    $this->AuthenLogin();
    $data = array();
    $data['HDSD_mota'] = $request->hdsd_mota;
    $data['HDSD_video'] = $request->hdsd_video;
    $productName = DB::table('sanpham')
                 ->where('sanpham_id', $product_id)
                 ->pluck('sanpham_ten')
                 ->first();

   
    DB::table('hdsd')->where('sanpham_id', $product_id)->update($data);
    Session::put('message','Cập nhật thành công');
    return Redirect::to('all-product'); 
}
    // end admin

    ## hiện sản phẩm trên trang "SẢN PHẨM"

    public function show_product(){

        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get();
        $product = DB::table('sanpham')->where('sanpham_trangthai', 1)->orderby('sanpham_id', 'desc')->paginate(9);
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
        return view('pages.product.shop')->with('danhmuc', $cate_product)->with('sanpham', $product)->with('phanloai', $phanloai)->with('hang', $brand);
    }

    public function show_details_product($product_id){
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); ## lấy id category
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

        return view('pages.product.show_details')->with('relate', $relate_product)->with('product', $details_product)->with('danhmuc', $cate_product)->with('brand', $brd_product);
    }


    public function show_chitiet_sanpham($sanpham_id){
    
 
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); // lấy id category
        $product = DB::table('sanpham')->where('sanpham_id', $sanpham_id)->
        join('danhmuc','danhmuc.danhmuc_id', '=', 'sanpham.danhmuc_id')->
        join('hangsanpham', 'hangsanpham.hang_id', '=', 'sanpham.hang_id')->
        first();

        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        ## sản phẩm tương tự
        ## lấy danh mục 
     
        $product_rela = DB::table('sanpham')
        ->where('danhmuc_id', $product->danhmuc_id)
        ->whereNotIn('sanpham_id', [$product->sanpham_id])
        ->limit(4)
        ->get();
    
        return view('pages.product.product_details')->with('phanloai', $phanloai) ->with('danhmuc', $cate_product)->with('sanpham', $product)->with('sanpham_tuongtu', $product_rela);

    }

   
}
