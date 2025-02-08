<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();

class CategoryProduct extends Controller
{
    
    public function AuthenLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return  Redirect::to('admin.dashboard');
        }else{
           return Redirect::to('admin')->send(); ## hàm send() có thể không cần thiết
        }
    }
    public function add_category_product ()
    {
        $this->AuthenLogin();
        return view('admin.add_category_product');
    }

    public function all_category_product ()
    {
        $this->AuthenLogin();
       $all_category = DB::table('category')->get(); ## lấy tấy cả dữ liêu
        $manger_category = view ('admin.all_category_product')->with('all_category', $all_category);
        return view('admin_layout')->with('admin.all_category_product',$manger_category); ## gom lại hiện chung

    }

    public function save_category_product (Request $request)    
    {
        $this->AuthenLogin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        $data['category_status'] = $request->category_product_status;
        /*
            $data['category_name'] : tên của cột trong database
            $request->category_product_name: tên của name lấy bên save_category
        */
        /*insert vào bảng*/
        DB::table('category')->insert($data);
        Session::put('message','Thêm danh mục sản phẩm mới thành công!');
        return Redirect::to('add-category-product'); ## Khi thêm thành công rồi thì trả lại về thêm danh mục sản phẩm
    }


    public function unactive_category_product($category_id){
        $this->AuthenLogin();
        DB::table('category')->where('category_id', $category_id)->update(['category_status' => 0]);
        Session::put('message','Cập nhật hiển thị thành công');
        return Redirect::to('all-category-product'); 
    }

    public function active_category_product($category_id){
        $this->AuthenLogin();
        DB::table('category')->where('category_id', $category_id)->update(['category_status' => 1]);
        Session::put('message','Cập nhật hiển thị thành công');
        return Redirect::to('all-category-product'); 
    }

    public function edit_category_product($category_id){
        $this->AuthenLogin();
        $category = DB::table('category')->where('category_id', $category_id)->get();
        $manger_category = view ('admin.edit_category_product')->with('edit_category', $category);
        return view('admin-layout')->with('admin.edit_category_product',$manger_category); ## gom lại hiện chung
    }


    public function delete_category_product($category_id){
        $this->AuthenLogin();
        DB::table('category')->where('category_id', $category_id)->delete();
        Session::put('message','Xóa danh mục thành công');
        return Redirect::to('all-category-product'); 
    }

    public function update_category_product(Request $request,$category_id){
        $this->AuthenLogin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        DB::table('category')->where('category_id', $category_id)->update($data);
        Session::put('message','update danh mục thành công');
        return Redirect::to('all-category-product'); 
    }
    //  End function của admin


    public function show_category_home($category_id){
        $cate_product = DB::table('category')->where('category_status', 1)->orderby('category_id', 'desc')->get(); ## lấy id category
        $brd_product = DB::table('brand')->where('brand_status', 1)->orderby('brand_id', 'desc')->get(); ## lấy id category
        $all = DB::table('product')
        ->join('category', 'category_product.category_id', '=', 'product.category_id')
        ->where('product.category_id', $category_id)
        ->get(); // Thêm phương thức get() để lấy tất cả dữ liệu
        $category_name = DB::table('category')->where('category_id', $category_id)->pluck('category_name')->first();
        return view('pages.category.show_category')->with('category_name',$category_name)->with('category', $cate_product)->with('brand', $brd_product)->with('category_id', $all);
    }
}
