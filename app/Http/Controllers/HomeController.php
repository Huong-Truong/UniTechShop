<?php


    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Session;
    use App\Http\Requests;
    use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
    session_start();

class HomeController extends Controller
{
    public function index()
    {
  
            $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); // lấy id category
            $product = DB::table('sanpham')->where('sanpham_trangthai', 1)->orderby('sanpham_id', 'desc')->limit(4)->get();
            $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
            $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
            
            return view('pages.home')->with('danhmuc', $cate_product)->with('sanpham', $product)->with('hang', $brand)->with('phanloai', $phanloai);
       
        
    }




    public function Search(Request $request){
        $keywords = $request->keywords_submit;
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_id', 'desc')->get(); ## lấy id category
        $brd_product = DB::table('tbl_brand_product')->where('brand_status', 1)->orderby('brand_id', 'desc')->get(); ## lấy id category
        // $all_product = DB::table('tbl_product')->where('product_status', 1)->orderby('brand_id', 'desc')->limit(4)->get();
        $search_product_by = DB::table('tbl_product')->where('product_status', 1)->where('product_name', 'like', '%'.$keywords.'%')->get();
        return view('pages.product.search')->with('category', $cate_product)->with('brand', $brd_product)->with('all_product', $search_product_by); ## trả về góc nhìn
    }



    public function login(){
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); ## lấy id category
        return view('login')->with('danhmuc', $cate_product);
    }

}
