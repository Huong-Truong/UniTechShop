<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();
use Cart;
class CartController extends Controller
{
    // protected $dv = "";
    // Session::put('dichvu', $dv);

  public function save_cart(Request $request){
        $sanphamId = $request->sanpham_id_hidden;
        $quantity = $request->qty;
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); ## lấy id category
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        $product_info = DB::table('sanpham')->where('sanpham_id', $sanphamId)->first();
        // Thử thêm một sp
        // Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        // Xóa giỏ hàng
        // Cart::destroy();
        $data['id'] = $product_info->sanpham_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->sanpham_ten;
        if(isset($request->gia_update)){
            $data['price'] = $request->gia_update;
        }else{
            $data['price'] = $product_info->sanpham_gia;
        }
      
        $data['weight'] = '1';
        $data['options']['image'] = $product_info->sanpham_hinhanh;
        Cart::add($data);
        ## set thuế 10% cho mỗi sản phẩm
        Cart::setGlobalTax(10);

        return redirect()->back();
        // return view('pages.cart.show_cart')->with('danhmuc', $cate_product)->with('phanloai', $phanloai);
    }
    public function delete_to_cart($rowID){
        Cart::update($rowID, 0);
        return Redirect::to('/show-cart');
    }
    public function update_cart_qty(Request $request) {
        $rowID = $request->rowID_cart;
        $qty = $request->cart_qty;
    
        // Update the cart quantity
        Cart::update($rowID, $qty);
    
        // Redirect to the show cart page
        return redirect('/show-cart');
    }
    
    // public function show_cart(){
    //     ## thêm dịch vụ nếu có 
    //     $dv=add_service_cart();
    //     $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); ## lấy id category
    //     $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
    //     return view('pages.cart.show_cart')->with('danhmuc', $cate_product)->with('phanloai', $phanloai)->with('dichvu', $dv);
    // }

    // public function add_service_cart(Request $request){
    //     $dichvu = DB::table('dichvu')
    //     ->join('sanpham', 'dichvu.sanpham_id', '=', 'sanpham.sanpham_id')
    //     ->where('dichvu.dv_id', $request->dichvu_id_hidden)->where('dichvu.sanpham_id', $request->sanpham_id_hidden)->get();
    //     return $dichvu;
    // }
    public function add_service_cart(Request $request)
    {
        $dichvu_chon = $request->input('dichvu_chon', []);
        $sanpham_id = $request->input('sanpham_id_hidden');
        $cart = Cart::content();

    // Kiểm tra sản phẩm có trong giỏ hàng không
    $product_in_cart = $cart->firstWhere('id', $sanpham_id);

    if (!$product_in_cart) {
        return redirect()->back()->with('error', 'Vui lòng thêm sản phẩm vào giỏ hàng trước khi chọn dịch vụ.');
    }

        $dv = DB::table('giadichvu')
            ->join('dichvukemtheo', 'dichvukemtheo.dv_id', '=', 'giadichvu.dv_id')
            ->join('sanpham', 'giadichvu.sanpham_id', '=', 'sanpham.sanpham_id')
            ->whereIn('dichvukemtheo.dv_id', $dichvu_chon)
            ->where('giadichvu.sanpham_id', $sanpham_id)
            ->select('dichvukemtheo.dv_ten', 'giadichvu.giadichvu', 'sanpham.sanpham_id', 'sanpham.sanpham_ten')
            ->get()
            ->toArray();

        // Cập nhật session với các dịch vụ đã chọn
        $existing_services = Session::get('dichvu', []);
        $updated_services = collect($existing_services)
            ->merge($dv)
            ->unique('dv_id') // Loại bỏ dịch vụ trùng lặp
            ->toArray();
        Session::put('dichvu', $updated_services);

        return redirect()->back();
    }

    public function delete_service_cart(Request $request)
    {
        // Lấy tên dịch vụ cần xóa từ request
        $dichvu_xoa = $request->input('dichvu_xoa'); // Dịch vụ cần xóa (chỉ một)
    
        if (!$dichvu_xoa) {
            return redirect()->back()->with('error', 'Không có dịch vụ nào được chọn để xóa.');
        }
    
        // Lấy danh sách dịch vụ hiện tại trong session
        $existing_services = Session::get('dichvu', []);
    
        // Tìm và xóa dịch vụ đầu tiên khớp với tên
        foreach ($existing_services as $key => $service) {
            if ($service->dv_ten === $dichvu_xoa) { // So sánh với dv_ten
                unset($existing_services[$key]);   // Xóa dịch vụ
                break; // Dừng vòng lặp sau khi xóa 1 dịch vụ
            }
        }
    
        // Cập nhật lại session
        Session::put('dichvu', $existing_services);
    
        return redirect()->back()->with('success', 'Dịch vụ đã được xóa khỏi giỏ hàng.');
    }
    


    public function show_cart(Request $request)
    {
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get();
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        $cart_content = Cart::content();
        $dv = Session::get('dichvu', []);
       
        return view('pages.cart.show_cart')
            ->with('danhmuc', $cate_product)
            ->with('phanloai', $phanloai)
            ->with('cart_content', $cart_content)
            ->with('dichvu', $dv);
    }
    
   
}
