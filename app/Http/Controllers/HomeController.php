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
            $product = DB::table('sanpham')->where('sanpham_trangthai', 1)->orderby('sanpham_id', 'desc')->limit(8)->get();
            $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
            $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
            $count_product_brand = DB::table('sanpham')->select('hang_id', DB::raw('count(*) as total'))->groupBy('hang_id')->get(); ## đếm số sản phẩm có trong hãng
            return view('pages.home')->with('count_prd_brand', $count_product_brand)->with('danhmuc', $cate_product)->with('sanpham', $product)->with('hang', $brand)->with('phanloai', $phanloai);
       
        
    }

   


    public function Search(Request $request){
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); ## lấy id category
        $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        $keywords_sp = $request->keywords;
        $search_product_by = DB::table('sanpham')->where('sanpham_trangthai', 1)->where('sanpham_ten','like', '%'.$keywords_sp.'%')->paginate(9);
        return view('pages.product.search')->with('danhmuc', $cate_product)->with('hang', $brand)->with('phanloai', $phanloai)->with('sanpham', $search_product_by);
    
    }



    public function login(){
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); ## lấy id category
        $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        return view('login')->with('danhmuc', $cate_product)->with('hang', $brand)->with('phanloai', $phanloai);
        // return view('login')->with('danhmuc', $cate_product);
    }

    public function contact(){
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); // lấy id category
        $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        return view('pages.contact')-> with('danhmuc', $cate_product)->with('hang', $brand)->with('phanloai', $phanloai);
    }

    public function services(){
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); // lấy id category
        $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        return view('pages.services')-> with('danhmuc', $cate_product)->with('hang', $brand)->with('phanloai', $phanloai);   
    }
}
