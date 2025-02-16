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
        $data['price'] = $product_info->sanpham_gia;
        $data['weight'] = '1';
        $data['options']['image'] = $product_info->sanpham_hinhanh;
        Cart::add($data);
        ## set thuế 10% cho mỗi sản phẩm
        Cart::setGlobalTax(10);

        return Redirect::to('/show-cart');
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
    
    public function show_cart(){
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); ## lấy id category
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        return view('pages.cart.show_cart')->with('danhmuc', $cate_product)->with('phanloai', $phanloai);
    }
}
