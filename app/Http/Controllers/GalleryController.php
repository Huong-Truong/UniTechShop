<?php

namespace App\Http\Controllers;

use Carbon\Traits\ToStringFormat;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use App\Models\HinhAnh;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
use App\Http\Controllers\Storage;
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

    public function update_gallery(Request $request){
        $data = array();
        $gal_id = $request->gal_id;
        // Lấy tên hình cũ
        $oldFileName = DB::table('hinhanh')->where('hinhanh_id',$gal_id)->pluck('hinhanh_ten')->first();
        // Láy id sản phảam
        $pro_id = DB::table('hinhanh')->where('hinhanh_id',$gal_id)->pluck('sanpham_id')->first();

        $data['hinhanh_ten'] = $request->gal_text;
        DB::table('hinhanh')->where('hinhanh_id', $gal_id)->update($data);
        // ĐỔi tên
        rename('img/sp'.$pro_id.'/' . $oldFileName, 'img/sp'.$pro_id.'/' . $data['hinhanh_ten'] );


        
    }

    public function select_gallery(Request $request){
        $product_id = $request->pro_id;
        // $gallery = DB::table('hinhanh')->where('sanpham_id',$product_id)->get();
        $gallery = HinhAnh::where('sanpham_id',$product_id)->get();
        $gallery_count = $gallery->count();
        $output = '
         <form>
                    '.csrf_field().'
                 <table class="table table-hover table-striped b-t b-light">
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
                                        <td>'.$i.'</td>
                                        <td contenteditable class="edit_gallery_name" data-gal_id="'.$value->hinhanh_id.'"> '.$value->hinhanh_ten.'</td>
                                        <td>
                                        <img src="'.asset('img/sp'.$value->sanpham_id.'/'.$value->hinhanh_ten).'" height="100" width="100" alt="Lỗi ảnh">
                                        </td>
                                        <td>
                                        <button type = "button" data-gal_id="'.$value->hinhanh_id.'" class = "btn btn-xs btn-danger
                                                 delete-gallery custom-button">Xóa</button>
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
        $output .= '
                         </tbody>
                        </table>
                        </form>
            ';


        echo $output;
       

    }       

 public function insert_gallery(Request $request, $product_id){
    $get_images = $request->file('file');
    $data = array();
    // Tìm số lớn nhất
    $images = DB::table('hinhanh')->where('sanpham_id',$product_id)->max('hinhanh_ten');
    // Tách lấy số
    preg_match('/\((\d+)\)/', $images, $matches);
    if($matches){
        $STT = (int)$matches[1] + 1;
    }
    //
    else {
        $STT = 1;
    }
 
 
    if ($get_images) {
        foreach ($get_images as $key => $image) {
            $new_image ='sp'. $product_id . '(' . $STT . ').' . $image->getClientOriginalExtension();
            $STT ++ ;
            // Di chuyển tệp tin đến thư mục đích
            $image->move('img/sp' . $product_id, $new_image);
            // Lưu thông tin ảnh vào cơ sở dữ liệu
            $data['hinhanh_ten'] = $new_image;
            $data['sanpham_id'] = $product_id;
            // insert vô hinhanh
            DB::table('hinhanh')->insert($data);
        }
        // Hiển thị thông báo thành công và chuyển hướng
        //Session::put('message', 'Thêm ảnh mới cho sản phẩm thành công!');
        return Redirect::to('add-gallery/'.$product_id);
    }
}

    // public function delete_gallery(Request $request){
    //     $gal_id = $request->gal_id;
    //      $gal_text = $request->gal_text;
    //      $pro_id = DB::table('hinhanh')->where('hinhanh_id', $gal_id)->pluck('sanpham_id')->first();
    //      echo $pro_id;
    //      if($pro_id){
    //          echo '../img/sp/'. $pro_id.'/'. $gal_text;
    //       }
    //     if( unlink('../img/sp/'. $pro_id.'/'. $gal_text)){
    //         echo "Thành công";
    //     } else echo "Thất bại";
      
    
    //     DB::table('hinhanh')->where('hinhanh_id', $gal_id)->delete();
    //     }
    public function delete_gallery(Request $request) {
        $gal_id = $request->gal_id;
        $gal_text = DB::table('hinhanh')->where('hinhanh_id', $gal_id)->pluck('hinhanh_ten')->first();
        $pro_id = DB::table('hinhanh')->where('hinhanh_id', $gal_id)->pluck('sanpham_id')->first();
    
        if ($pro_id) {
            $file_path = 'img/sp'.$pro_id.'/'.$gal_text ;
            if (file_exists($file_path)) {
                if (unlink($file_path)) {
                    echo "Thành công";
                } else {
                    echo "Thất bại: Không thể xóa file.";
                }
            } else {
                echo "Thất bại: File không tồn tại.";
            }
        } else {
            echo "Thất bại: Không tìm thấy sản phẩm.";
        }
    
        DB::table('hinhanh')->where('hinhanh_id', $gal_id)->delete();
    }
}





