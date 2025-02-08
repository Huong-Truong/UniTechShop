<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();
use Cart;

class CheckOutController extends Controller
{

    
    public function logout_check_out(){
     Session::flush();
     return Redirect::to('/login-check-out');   
    }
    public function login_check_out(){
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_id', 'desc')->get(); ## lấy id category
        $brd_product = DB::table('tbl_brand_product')->where('brand_status', 1)->orderby('brand_id', 'desc')->get(); ## lấy id category
      return  view('pages.checkout.login_checkout')->with('category', $cate_product)->with('brand', $brd_product);
    }

    public function login_customer(Request $request){
        $email_account = $request->email_account;
        $password_account = md5($request->password_account); ## mã hóa rồi so sánh đúng chuỗi kh
        $result = DB::table('tbl_customer')->where('customer_email', $email_account)->where('customer_password', $password_account)->first();
        
       
        if($result){
            Session::put('customer_id', $result->customer_id);
            return Redirect::to('/check-out');
        }else{
            return Redirect::to('/login-check-out');
        }
      
    
    }

    ## đăng ký nè
    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request->name;
        $data['customer_email'] = $request->email;
        $data['customer_password'] = md5($request->pass);
        $data['customer_phone'] = $request->phone;

        $insert_data = DB::table('tbl_customer')->insertGetId($data); ## khi insert vào rồi, LẤY LUÔN DỮ LIỆU ID ĐÃ INSERT

        Session::put('customer_id', $insert_data);
        Session::put('customer_name', $request->customer_name);

        return Redirect::to('/check-out');
     
    }

    public function check_out(){
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_id', 'desc')->get(); ## lấy id category
        $brd_product = DB::table('tbl_brand_product')->where('brand_status', 1)->orderby('brand_id', 'desc')->get(); ## lấy id category
          return  view('pages.checkout.checkout')->with('category', $cate_product)->with('brand', $brd_product);
    }

    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_notes'] = $request->shipping_notes;
        $insert_data = DB::table('tbl_shipping')->insertGetId($data); ## khi insert vào rồi, LẤY LUÔN DỮ LIỆU ID ĐÃ INSERT

        Session::put('shipping_id', $insert_data);


        return Redirect::to('/payment');
    }

    public function payment(){
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_id', 'desc')->get(); ## lấy id category
        $brd_product = DB::table('tbl_brand_product')->where('brand_status', 1)->orderby('brand_id', 'desc')->get(); ## lấy id category
          return  view('pages.checkout.payment')->with('category', $cate_product)->with('brand', $brd_product);
    }

    public function order_place(Request $request){
        // Lấy payment method và insert
        $data = array();
        $data['payment_method'] = $request->options;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data); ## khi insert vào rồi, LẤY LUÔN DỮ LIỆU ID ĐÃ INSERT

        // insert order
        $order_data  = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Đang chờ xử lý';

        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        $content = Cart::content();
        foreach($content as $v_content){
            $order_details_data['order_id'] = $order_id;
            $order_details_data['product_id'] = $v_content->id;
            $order_details_data['product_name'] = $v_content->name;
            $order_details_data['product_price'] = $v_content->price;
            $order_details_data['product_sales_quantity'] = $v_content->qty;
            $result = DB::table('tbl_order_details')->insert($order_details_data);
        }



      
        if($data['payment_method'] == 1) {
            
            echo 'Thanh Toán Thẻ ATM';
        
        }
         else if ($data['payment_method'] == 2) {
            
            $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_id', 'desc')->get(); ## lấy id category
            $brd_product = DB::table('tbl_brand_product')->where('brand_status', 1)->orderby('brand_id', 'desc')->get(); ## lấy id category
            Cart::destroy(); ## đã đặt hàng xong thì hủy giỏ hàng, kh cần để lại làm gì
            return view('pages.checkout.handcash')->with('category',$cate_product)->with('brand',$brd_product);
            }
        else{ 
            echo 'thẻ ghi nợ'; 
        }
        // return Redirect::to('/payment');
    }


    ## HÀM QUẢN LÝ ORDER CỦA ADMIN:
    public function AuthenLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return  Redirect::to('admin.dashboard');
        }else{
           return Redirect::to('admin')->send(); ## hàm send() có thể không cần thiết
        }
    }
    public function manage_orders(){
        $this->AuthenLogin();
        $all_orders = DB::table('tbl_order')
        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
        ->select('tbl_order.*', 'tbl_customer.customer_name')
        ->orderby('tbl_order.order_id', 'desc')->get(); // Thêm phương thức get() để lấy tất cả dữ liệu
    
        return view ('admin.manage_orders')->with('all', $all_orders);
        // return view('admin_layout')->with('admin.manage_orders',$manger); ## gom lại hiện chung

    }

    public function view_order($order_id){
        $this->AuthenLogin();
        ## thông tin chi tiết đơn hàng
        $all_orders_details = DB::table('tbl_order_details')->where('order_id', $order_id)->get();
     
        ## thông tin người mua + vận chuyển
        $all_payment_customer = DB::table('tbl_order')
        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
        ->join('tbl_payment', 'tbl_payment.payment_id', '=', 'tbl_order.payment_id')
        ->join('tbl_shipping', 'tbl_shipping.shipping_id', '=', 'tbl_order.shipping_id')
        ->where('tbl_order.order_id', $order_id)
        ->get();

        return view ('admin.view_order')->with('all_details', $all_orders_details)->with('customer',$all_payment_customer);

    }
}
