<?php

namespace App\Http\Controllers;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();
use Cart;
use App\Mail\OrderDetails;
use App\Http\Controllers\PayPalController;

class CheckOutController extends Controller
{


    public function account(){
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get();
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        $tk = Session::get('khachhang_id');
    
        // Lấy thông tin đơn hàng
        $donhang = DB::table('donhang')->where('khachhang_id', $tk)
            ->join('thanhtoan', 'thanhtoan.pttt_id', '=', 'donhang.thanhtoan_id')
            ->join('vanchuyen', 'vanchuyen.vanchuyen_id', '=', 'donhang.vanchuyen_id')
            ->join('chitiettrangthai', 'chitiettrangthai.donhang_id', '=', 'donhang.donhang_id')
            ->join('trangthai', 'trangthai.trangthai_id', '=', 'chitiettrangthai.trangthai_id')
            ->select('donhang.danhgia','donhang.donhang_id', 'donhang_tongtien', 'pttt_ten', 'vanchuyen_diachi', 'trangthai_ten', 'trangthai.trangthai_id','donhang_ngaytao')
            ->get();
    
        // Tạo mảng để chứa tất cả các chi tiết đơn hàng
        $ctdh = []; // Mảng chi tiết sản phẩm toàn bộ
    
        foreach ($donhang as $v_donhang) {
            $sanphamDetails = DB::table('chitietdonhang')->where('donhang_id', $v_donhang->donhang_id)
                ->join('sanpham', 'sanpham.sanpham_id', '=', 'chitietdonhang.sanpham_id')
                ->select(
                    'chitietdonhang.ctdh_id',
                    'chitietdonhang.donhang_id',
                    'chitietdonhang.sanpham_gia', 
                    'chitietdonhang.sanpham_ten', 
    
                    'chitietdonhang.sanpham_id', 
                    'ctdh_soluong', 
                    'sanpham_hinhanh'
                )
                ->get();
    
            // Thêm các sản phẩm của từng đơn hàng vào mảng ctdh chung
            foreach ($sanphamDetails as $sanpham) {
                $ctdh[] = [
                    'ctdh_id' =>  $sanpham->ctdh_id,
                    'donhang_id' => $sanpham->donhang_id,
                    'sanpham_gia' => $sanpham->sanpham_gia,
                    'sanpham_ten' => $sanpham->sanpham_ten,
                    'sanpham_id' => $sanpham->sanpham_id,
                    'ctdh_soluong' => $sanpham->ctdh_soluong,
                    'sanpham_hinhanh' => $sanpham->sanpham_hinhanh
                ];
            }
        }
    
        $taikhoan = DB::table('khachhang')->where('khachhang_id', $tk)->first();
        //  lấy đánh giá của account
        $danhgia = DB::table('danhgia')
        ->join('sanpham','sanpham.sanpham_id', '=', 'danhgia.sanpham_id')
        ->where('khachhang_id', $tk)
        ->get();
        return view('pages.checkout.account')
            ->with('danhgia', $danhgia)
            ->with('ctdh', $ctdh) // Truyền mảng chi tiết đơn hàng vào view
            ->with('donhang', $donhang)
            ->with('taikhoan', $taikhoan)
            ->with('danhmuc', $cate_product)
            ->with('phanloai', $phanloai);
    }

    public function update_info(Request $request){
        $data = array();
        $khachhang_id = $request->khachhang_id;
        $data['khachhang_ten'] = $request->name;
     
        ## chỉnh md5 không? md5( $request->pass)
        $data['khachhang_email'] = $request->email;
        $data['khachhang_sdt'] = $request->phone;
        $data['khachhang_diachi'] = $request->address;
        DB::table('khachhang')->where('khachhang_id', $khachhang_id)->update($data);
        $success = "Da cap nhat thanh cong";
        Session::put('success',$success);
        return redirect()->back();
    }
    
    public function dangky_khachhang(Request $request){
        $data = array();
        $data['khachhang_ten'] = $request->name;
        $data['khachhang_matkhau'] = $request->pass;
        ## chỉnh md5 không? md5( $request->pass)
        $data['khachhang_email'] = $request->email;
        $data['khachhang_sdt'] = $request->phone;
        $data['khachhang_diachi'] = $request->address;
        $insert_khachhang = DB::table('khachhang')->insertGetId($data); // Lấy ID của bản ghi mới chèn
        
        Session::put('khachhang_id', $insert_khachhang); // Lưu ID vào session
        Session::put('khachhang_ten', $request->name); // Lưu tên khách hàng vào session
        if(Cart::content()->count() > 0){
            return Redirect::to('/checkout');
        }else{
            return Redirect::to('/');
        }
        
    }

    public function login_khachhang(Request $request){
        $email = $request->khachhang_email;
        $password = $request->khachhang_matkhau;
        
        $result = DB::table('khachhang')->where('khachhang_email', $email)->where('khachhang_matkhau',$password)->pluck('khachhang_id')->first();
        if($result){
            Session::put('khachhang_id', $result); // Lưu ID vào session
            if(Cart::content()->count() > 0){
                return Redirect::to('/checkout');
            }else{
               
                return Redirect::to('/');
            }
           
          
        }else{
            // $lan_dn_sai;
            // Session::put('solan',$lan_dn_sai);
            Session::put('message','Tài khoản hoặc mật khẩu không đúng');
            return Redirect::to('/login-checkout');
        }
       
       


    }

    public function login_checkout(){
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); ## lấy id category
        $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        return view('login')->with('danhmuc', $cate_product)->with('hang', $brand)->with('phanloai', $phanloai);
    }



    public function logout_checkout(){
        Session::flush();
        return Redirect('/login-checkout');
    }
    


    public function checkout(){
        $khachhang_id = Session::get('khachhang_id');
        if($khachhang_id){
            $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get();
            $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
            $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
            $khachhang = DB::table('khachhang')->where('khachhang_id', $khachhang_id)->first(); // Access the session data as an integer
            return view('pages.checkout.checkout')->with('danhmuc', $cate_product)->with('hang', $brand)->with('phanloai', $phanloai)->with('khachhang', $khachhang);
        } else {
            return Redirect::to('/login-checkout');
        }
    }
    
    public function payment(){
        $khachhang_id = Session::get('khachhang_id');
        if($khachhang_id){
            $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get();
            $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
            $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
            $khachhang = DB::table('khachhang')->where('khachhang_id', $khachhang_id)->first(); // Access the session data as an integer
            $vanchuyen_id = Session::get('vanchuyen_id');
            $vanchuyen = DB::table('vanchuyen')->where('vanchuyen_id', $vanchuyen_id)->get();
            $dichvu = Session::get('dichvu');
            return view('pages.checkout.payment')->with('dichvu', $dichvu)->with('danhmuc', $cate_product)->with('hang', $brand)->with('vanchuyen', $vanchuyen)->with('phanloai', $phanloai)->with('khachhang', $khachhang);
        } else {
            return Redirect::to('/login-checkout');
        }
    }
    
    



    public function save_checkout(Request $request){
        $data = array();
        $data['vanchuyen_nguoinhan'] = $request->nguoinhan;

        $data['vanchuyen_email'] = $request->email;
        $data['vanchuyen_sdt'] = $request->sdt;
        $data['vanchuyen_diachi'] = $request->diachi;
        if($request->ghichu != NULL){
            $data['vanchuyen_ghichu'] = $request->ghichu;
        }else{
            $data['vanchuyen_ghichu'] = "none";
        }
        $insert_vanchuyen = DB::table('vanchuyen')->insertGetId($data); // Lấy ID của bản ghi mới chèn
        Session::put('vanchuyen_id', $insert_vanchuyen); // Lưu ID vào session
        return Redirect::to('/payment');
    }

    
    // public function payment(){
    //     $khachhang_id = Session::get('khachhang_id');
    //     $id = $khachhang_id->khachhang_id;
    //     if($khachhang_id != NULL){
    //         $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get();
    //         $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
    //         $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
    //         $khachhang = DB::table('khachhang')->where('khachhang_id', $id)->first();
    //         $vanchuyen_id = Session::get('vanchuyen_id');
    //         $vanchuyen = DB::table('vanchuyen')->where('vanchuyen_id', $vanchuyen_id)->get();
    //         return view('pages.checkout.payment')->with('danhmuc', $cate_product)->with('hang', $brand)->with('vanchuyen', $vanchuyen)->with('phanloai', $phanloai)->with('khachhang', $khachhang);
    //     }
           
    // }

   



### cũ
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

    

    public function order_place(Request $request){
            // order 
            $order_data = array();
            $order_data['thanhtoan_id'] = $request->payment_option;
            $order_data['khachhang_id'] = Session::get('khachhang_id');
            $order_data['vanchuyen_id'] = Session::get('vanchuyen_id');
            $order_data['donhang_tongtien'] = Cart::total();
            $result  = DB::table('donhang')->insertGetId($order_data);
            // order details
            $content = Cart::content();
            foreach($content as $v_content){
                $order_d_data = array();
                $order_d_data['donhang_id'] = $result;
                $order_d_data['sanpham_id'] = $v_content->id;
                $order_d_data['sanpham_ten'] = $v_content->name;
                $order_d_data['sanpham_gia'] = $v_content->price;
                $order_d_data['ctdh_soluong'] =$v_content->qty ;
              DB::table('chitietdonhang')->insert($order_d_data);
            }
     
            // chi tiet trạng thái đơn hàng
            $data_status = array();
            $data_status['donhang_id'] = $result;
            $data_status['trangthai_id'] = "1";

            DB::table('chitiettrangthai')->insert($data_status);

            // if( $order_data['thanhtoan_id'] == 1){
            //     echo 'Thanh toán bằng Momo';
            // }else if($order_data['thanhtoan_id'] == 2 ){
            //     echo "Thanh toán khi nhận hàng";
            // }else{
            //     echo "Thanh toán bằng thẻ ngân hàng";
            // }
            // Có thể cart destroy sau khi đã đặt hàng xong
            // Cart::destroy();
           


        
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
    public function manage_orders(Request $request){
        $this->AuthenLogin();
        $query = DB::table('donhang')
        ->join('khachhang', 'khachhang.khachhang_id', '=', 'donhang.khachhang_id')
        ->join('chitiettrangthai', 'donhang.donhang_id', '=', 'chitiettrangthai.donhang_id')
        ->join('trangthai','trangthai.trangthai_id', '=', 'chitiettrangthai.trangthai_id' )
        ->select('donhang.*', 'khachhang.khachhang_ten', 'trangthai.trangthai_ten', 'chitiettrangthai.trangthai_id')
        ->orderby('donhang.donhang_id', 'desc'); // Thêm phương thức get() để lấy tất cả dữ liệu
        if($key = $request->key){
            $query->where('khachhang_ten', 'like', '%' . $key . '%')
            ->orWhere('donhang_ngaytao', 'like', '%' . $key . '%')
            ->orWhere('trangthai_ten', 'like', '%' . $key . '%');
        }
        $all_orders = $query->get();
       // $donhang_id = $all_orders->pluck('donhang.donhang_id')->first();
        $trangthai = DB::table('trangthai')->get();

        
        
        return view ('admin.order.manage_orders')->with('all', $all_orders)->with('trangthai', $trangthai);
        // return view('admin_layout')->with('admin.manage_orders',$manger); ## gom lại hiện chung

    }

    public function view_order($donhang_id){
        $this->AuthenLogin();
        ## thông tin chi tiết đơn hàng
        $all_orders_details = DB::table('chitietdonhang')->where('donhang_id', $donhang_id)->get();
     
        ## thông tin người mua + vận chuyển
        $all_payment_customer = DB::table('donhang')
        ->join('khachhang', 'khachhang.khachhang_id', '=', 'donhang.khachhang_id')
        ->join('thanhtoan', 'thanhtoan.pttt_id', '=', 'donhang.thanhtoan_id')
        ->join('vanchuyen', 'vanchuyen.vanchuyen_id', '=', 'donhang.vanchuyen_id')
        ->where('donhang.donhang_id', $donhang_id)
        ->get();

        return view ('admin.order.view_order')->with('all_details', $all_orders_details)->with('customer',$all_payment_customer);

    }

    ## cập nhật trạng thái đơn hàng
    public function update_status(Request $request){
        $data = array();
        $data['trangthai_id'] = $request->trangthai_donhang;

        ## update tồn kho
        $sanpham = DB::table('chitietdonhang')->where('donhang_id', $request->donhang_id)->get();
        if($request->check){
            if($request->check == 1){
                DB::table('chitiettrangthai')->where('donhang_id', $request->donhang_id)->update($data);
            }
        }else{
            DB::table('chitiettrangthai')->where('donhang_id', $request->donhang_id)->update($data);
            if($request->trangthai_donhang != "1"){
                foreach($sanpham as $v_sanpham){
                    $kho1 =DB::table('tonkho')->where('kho_id', 1)->where('sanpham_id', $v_sanpham->sanpham_id)->pluck('tonkho_soluong')->first();
                    $kho2 =DB::table('tonkho')->where('kho_id', 2)->where('sanpham_id', $v_sanpham->sanpham_id)->pluck('tonkho_soluong')->first();
                    if($kho1 > 0){
                        $kho1 = $kho1 - $v_sanpham->ctdh_soluong;
                        DB::table('tonkho')->where('kho_id', 1)->where('sanpham_id', $v_sanpham->sanpham_id)->update(['tonkho_soluong'=>$kho1]);
                    }else if($kho2 > 0){
                        $kho2 = $kho2 - $v_sanpham->ctdh_soluong;
                        DB::table('tonkho')->where('kho_id', 2)->where('sanpham_id', $v_sanpham->sanpham_id)->update(['tonkho_soluong'=>$kho2]);
                    }
                }
            }
        }
        
        return redirect()->back();

    }

    public function send_order(Request $request)
    {

        $vc = DB::table('vanchuyen')->where('vanchuyen_id', $request->vanchuyen)->first();
        $mail_nhan = $vc->vanchuyen_email;
        $subject = "THÔNG TIN ĐƠN HÀNG";
        Session::put('subject_order', $subject); // lấy tiêu đề (title của mail)
        Session::put('shipping_order', $vc->vanchuyen_id);
        $payment = DB::table('thanhtoan')->where('pttt_id', $request->payment_option)->pluck('pttt_ten')->first();
        Session::put('payment_order', $payment);
                  // order 
                  $order_data = array();
                  $order_data['thanhtoan_id'] = $request->payment_option;
                  $order_data['khachhang_id'] = Session::get('khachhang_id');
                  $order_data['vanchuyen_id'] = Session::get('vanchuyen_id');
                  $order_data['donhang_tongtien'] = (int)(preg_replace('/[^0-9.]/', '', Cart::total()));
                 
                  $result  = DB::table('donhang')->insertGetId($order_data);
                  // order details
                  $content = Cart::content();
                  foreach($content as $v_content){
                      $order_d_data = array();
                      $order_d_data['donhang_id'] = $result;
                      $order_d_data['sanpham_id'] = $v_content->id;
                      $order_d_data['sanpham_ten'] = $v_content->name;
                      $order_d_data['sanpham_gia'] = $v_content->price;
                      $order_d_data['ctdh_soluong'] =$v_content->qty ;
                    DB::table('chitietdonhang')->insert($order_d_data);
                  }
           
                  // chi tiet trạng thái đơn hàng
                  $data_status = array();
                  $data_status['donhang_id'] = $result;
                  $data_status['trangthai_id'] = "1";
      
                  DB::table('chitiettrangthai')->insert($data_status);
      
        if ($request->payment_option == "3") {
            return $this->vnpay_payment($request); // Gọi hàm vnpay_payment
        }else if ($request->payment_option=="1"){
            
        return (new PayPalController())->payment($request);

        }
    
        $this->send_order_email($mail_nhan);
        return Redirect::to('/trang-chu');
    }
    
    public function vnpay_payment(Request $request)
    {
        $vnp_TmnCode = config('vnpay.vnp_TmnCode');
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_Url = config('vnpay.vnp_Url');
        $vnp_ReturnUrl = config('vnpay.vnp_ReturnUrl');
    
        $vnp_TxnRef = date("YmdHis"); // Mã đơn hàng
        $vnp_OrderInfo = "Thanh toán đơn hàng";
        $vnp_OrderType = 'billpayment';
        $tiendv = 0;
        $dichvu = Session::get('dichvu');
    
        if($dichvu){
            foreach($dichvu as $dv){
                $tiendv = $tiendv + $dv->giadichvu;
            }
            $subtotal = Cart::subtotal();
            $subtotal = preg_replace('/[^\d.]/', '', $subtotal); // Loại bỏ các ký tự không phải số
            $subtotal = floatval($subtotal);
           
            $subtotal = Cart::total();
            $subtotal = preg_replace('/[^\d.]/', '', $subtotal); // Loại bỏ các ký tự không phải số
    
            if (is_numeric($subtotal)) {
                $subtotal = floatval($subtotal); // Chuyển đổi thành giá trị số thập phân
                $subtotal = $subtotal + $tien_dv; // Cộng thêm phí dịch vụ vào tổng số
            }
             $vnp_Amount =  $subtotal  * 100;
        }else{
            $subtotal = Cart::total();
            $subtotal = preg_replace('/[^\d.]/', '', $subtotal); // Loại bỏ các ký tự không phải số
            $subtotal = floatval($subtotal);
            $vnp_Amount =  $subtotal  * 100;
        }
       
     

        $vnp_Locale = 'vn';
        // $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $request->ip();
    
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
            // "vnp_BankCode" => $vnp_BankCode
        );
    
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
    
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
    
        return redirect($vnp_Url);
    }
    
    public function return(Request $request)
    {
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $inputData = $request->all();
        $vnpSecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
    
        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $hashData = rtrim($hashData, '&');
    
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
    
        if ($secureHash === $vnpSecureHash) {
            // Chữ ký hợp lệ, tiến hành xử lý kết quả thanh toán
            $orderId = $inputData['vnp_TxnRef'];
            $vnp_ResponseCode = $inputData['vnp_ResponseCode'];
    
            if ($vnp_ResponseCode == '00') {
                // Thanh toán thành công
                // Cập nhật trạng thái đơn hàng trong cơ sở dữ liệu
                // Ví dụ: $order = Order::find($orderId);
                // $order->status = 'paid';
                // $order->save();
                $mail_nhan = DB::table('vanchuyen')->where('vanchuyen_id', Session::get('shipping_order'))->pluck('vanchuyen_email')->first();
                $this->send_order_email($mail_nhan);
                $tb="Thanh toán thành công, vui lòng kiểm tra email";
                Session::put('success',  $tb);
                return Redirect::to('/');
            }else{
                $tb="Thanh toán không thành công";
                Session::put('error',  $tb);
                return Redirect::to('/');
            }
        
        } else {
            // Chữ ký không hợp lệ
            return response()->json([
                'code' => '97',
                'message' => 'Chữ ký không hợp lệ',
            ]);
        }
    }
    
    public function send_order_email($mail_nhan)
    {
        
        $new_mail = new OrderDetails();
        Mail::to($mail_nhan)->send($new_mail);

        
    }

    
    
    public function search_order(Request $request){
        return $this->manage_orders($request);
    }    

}


