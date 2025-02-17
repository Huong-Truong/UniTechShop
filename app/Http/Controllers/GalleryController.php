<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use App\HinhAnh;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();

use Illuminate\Http\Request;

class GalleryController extends Controller
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

    public function add_gallery ($product_id)
    {
        $pro_id = $product_id;

       return view('admin.gallery.add_gallery')->with('pro_id',$pro_id);
    }

    public function select_gallery(Request $request){
        $product_id = $request->pro_id;
        $gallery = DB::table('hinhanh')->where('sanpham_id',$product_id)->get();
        $gallery_count = $gallery->count();
        $output = '
                 <table class="table table-hover">
                                    <thead>
                                      <tr>
                                        <th>STT</th>
                                        <th>Tên </th>
                                        <th>Hình ảnh</th>
                                        <th>Quản lý</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    
        ';
        if($gallery_count > 0){
            $i = 0;
            foreach($gallery as $key => $value){
                $i++;
                $output .= '
                                    <tr>
                                        <td>'.$i++.'</td>
                                        <td>'.$value->hinhanh_ten.'</td>
                                        <td>
                                        <img src="'.asset('img/sp'.$value->sanpham_id.'/'.$value->hinhanh_ten).'" height="100" width="100" alt="Lỗi ảnh">
                                        </td>
                                        <td>
                                        <button data-gal_id="'.$value->hinhanh_id.'" class = "btn btn-xs btn-danger
                                                 delete-gallerygallery">Xóa</button>
                                        </td>
                                    </tr>
                ';
           }
        } else {
            $output .= '
                                <tr>
                                   <td colspan="4" >Sản phẩm này chưa có thư viện ảnh</td>
                                </tr>
           ';

        }
        echo $output;
       

    }       

 public function insert_gallery(Request $request, $product_id)
{
    $get_images = $request->file('file');
    $productName = DB::table('sanpham')
                 ->where('sanpham_id', $product_id)
                 ->pluck('sanpham_ten')
                 ->first();
    $data = array();
    if ($get_images) {
        $i = 1;
        foreach ($get_images as $key => $image) {
            $new_image = str_replace(' ', '', $productName) . '(' . $i . ').' . $image->getClientOriginalExtension();
            $i++;
            // Di chuyển tệp tin đến thư mục đích
            $image->move('img/sp' . $product_id, $new_image);
            // Lưu thông tin ảnh vào cơ sở dữ liệu
            $data['hinhanh_ten'] = $new_image;
            $data['sanpham_id'] = $product_id;
            // insert vô hinhanh
            DB::table('hinhanh')->insert($data);
        }
        // Hiển thị thông báo thành công và chuyển hướng
        Session::put('message', 'Thêm ảnh mới cho sản phẩm thành công!');
        return Redirect::to('all-product');
    }
}

}