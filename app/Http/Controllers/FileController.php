<?php
namespace App\Http\Controllers;

use App\Models\Classify;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();

class FileController extends Controller
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
    public function download_classify()
    {
        $this->AuthenLogin();
        $file = '..\public\excel\classify.csv'; // Đường dẫn tới tệp bạn muốn tải xuống
        return response()->download(storage_path($file));
    }
    public function download_cate()
    {
        $this->AuthenLogin();
        $file = '..\public\excel\category.csv'; // Đường dẫn tới tệp bạn muốn tải xuống
        return response()->download(storage_path($file));
    }
    public function download_brand()
    {
        $this->AuthenLogin();
        $file = '..\public\excel\brand.csv'; // Đường dẫn tới tệp bạn muốn tải xuống
        return response()->download(storage_path($file));
    }
    public function download_product()
    {
        $this->AuthenLogin();
        $file = '..\public\excel\product.csv'; // Đường dẫn tới tệp bạn muốn tải xuống
        return response()->download(storage_path($file));
    }

    public function download_hdn()
    {
        $this->AuthenLogin();
        $file = '..\public\excel\hoadonnhap.csv'; // Đường dẫn tới tệp bạn muốn tải xuống
        return response()->download(storage_path($file));
    }


    public function export_classify(Request $request){
        $this->AuthenLogin();
        $filename = "exported/Classifys.csv";
        $classifys= Classify::all();

        $handle = fopen($filename, 'w');
        fputcsv($handle, ['phanloai_ten']);

        foreach ($classifys as $classify) {
            fputcsv($handle, [$classify->phanloai_ten]);
        }

        fclose($handle);

        return response()->download($filename);

    }

    public function export_category(Request $request){
        $this->AuthenLogin();
        $filename = "exported/Categorys.csv";
        $categorys= Category::all();

        $handle = fopen($filename, 'w');
        fputcsv($handle, ['danhmuc_ten,phanloai_id']);

        foreach ($categorys as $category) {
            fputcsv($handle, [$category->danhmuc_ten,$category->phanloai_id]);
        }

        fclose($handle);

        return response()->download($filename);

    }

    public function export_brand(Request $request){
        $this->AuthenLogin();
        $filename = "exported/Brands.csv";
        $brands=  Brand::all();

        $handle = fopen($filename, 'w');
        fputcsv($handle, ['hang_ten,hang_mota']);

        foreach ($brands as $brand) {
            fputcsv($handle, [$brand->hang_ten,$brand->hang_mota]);
        }

        fclose($handle);

        return response()->download($filename);

    }

    
    public function export_product(Request $request){
        $this->AuthenLogin();
        $filename = "exported/Products.csv";
        $products=  Product::all();

        $handle = fopen($filename, 'w');
        fputcsv($handle, ['sanpham_ten','hang_id','danhmuc_id','sanpham_gia','sanpham_hinhanh',
       ' sanpham_mota','sanpham_thongso','sanpham_xuatxu']);

        foreach ($products as $product) {
            fputcsv($handle, [$product->sanpham_ten,$product->hang_id,$product->danhmuc_id,
            $product->sanpham_gia,$product->sanpham_hinhanh,$product->sanpham_mota,$product->sanpham_thongso,$product->xuatxu]);
        }

        fclose($handle);

        return response()->download($filename);

    }
}
