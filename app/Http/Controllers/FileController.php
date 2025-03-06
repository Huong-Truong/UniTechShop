<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();

class FileController extends Controller
{
    //
    public function download_classify()
    {
        $file = '..\public\excel\classify.csv'; // Đường dẫn tới tệp bạn muốn tải xuống
        return response()->download(storage_path($file));
    }
    public function download_cate()
    {
        $file = '..\public\excel\cate.csv'; // Đường dẫn tới tệp bạn muốn tải xuống
        return response()->download(storage_path($file));
    }
    public function download_brand()
    {
        $file = '..\public\excel\brand.csv'; // Đường dẫn tới tệp bạn muốn tải xuống
        return response()->download(storage_path($file));
    }
    public function download_product()
    {
        $file = '..\public\excel\product.csv'; // Đường dẫn tới tệp bạn muốn tải xuống
        return response()->download(storage_path($file));
    }
}
