<?php


    namespace App\Http\Controllers;
    use Mail;
    use App\Mail\Send;
    use App\Mail\contact;
    use App\Mail\ForgotPass;
    use App\Mail\OrderDetails;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Session;
    use App\Http\Requests;
    use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
    session_start();

class HomeController extends Controller
{
    public function AuthenLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return  Redirect::to('admin.dashboard');
        }else{
           return Redirect::to('admin')->send(); ## hàm send() có thể không cần thiết
        }
    }
    public function login_backup(){
        return view('login_backup');
    }

    public function signup(){
        return view('signup');
    }


    public function unactive_product_storage(){
        $sp =   DB::table('sanpham')->get();
        foreach($sp as $key => $value){
            $sl_kho = DB::table('tonkho')->where('sanpham_id', $value->sanpham_id)->sum('tonkho_soluong');
            if($sl_kho == 0){
                DB::table('sanpham')->where('sanpham_id', $value->sanpham_id)->update(['sanpham_trangthai' => 0]);
            }else{
                DB::table('sanpham')->where('sanpham_id', $value->sanpham_id)->update(['sanpham_trangthai' => 1]);
            }
        }    
    }
    public function index()
    {
         $this->unactive_product_storage();
            $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); // lấy id category
            $product = DB::table('sanpham')->where('sanpham_trangthai', 1)->orderby('sanpham_id', 'desc')->limit(8)->get();
            $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
            $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
            $count_product_brand = DB::table('sanpham')->select('hang_id', DB::raw('count(*) as total'))->groupBy('hang_id')->get(); ## đếm số sản phẩm có trong hãng
            $today = Date('Y-m-d');
            $khuyenmai = DB::table('thongtinkhuyenmai')
            ->join('khuyenmai','thongtinkhuyenmai.km_id', '=', 'khuyenmai.km_id')
            ->join('sanpham', 'sanpham.sanpham_id','=', 'thongtinkhuyenmai.sanpham_id')
            ->whereDate('thongtinkhuyenmai.ngaybatdau' ,'<=', $today)
            ->whereDate('thongtinkhuyenmai.ngayketthuc', '>=', $today)->get();  
            return view('pages.home')->with('khuyenmai', $khuyenmai)->with('count_prd_brand', $count_product_brand)->with('danhmuc', $cate_product)->with('sanpham', $product)->with('hang', $brand)->with('phanloai', $phanloai);
       
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

  
    // Quen mat khau
    public function forgot_pass(){
        return view('admin_forgot_password');
    }
    public function send_mail(){
        $email = 'chienb2203431@student.ctu.edu.vn';
        $new_mail = new Send();
        Mail::to($email)->send($new_mail);
    }

    public function review_pass(Request $request) {
        $email = $request->email;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$%&';
        $length = 6;
        $characterLength = strlen($characters) -1;
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $characterLength - 1)];
        }
        
        $new_pass = $randomPassword;
        $data['admin_password'] = md5($new_pass);

        $admin_email = DB::table('admin')->where('admin_email', $email)->first();
        if($admin_email){
            $new_mail = new ForgotPass();
            DB::table('admin')->where('admin_email', $email)->update($data);
            Session::put('message', 'Mật khẩu mới đã được gửi đến mail của bạn');
            Session::put('new_pass',$new_pass);
            Mail::to($email)->send($new_mail);
            return Redirect::to('/admin');
        }
        else {
            Session::put('message', 'Tài khoản không tồn tại, vui lòng nhập lại');
            return Redirect::to('/forgot-pass');
        }
    
      
       
    }

   
    public function send_contact(Request $request){
        {
        $emails = [ 'chienb2203431@student.ctu.edu.vn', 'huongb2203445@student.ctu.edu.vn'];

        $email_nguoigui = $request->email_kh;
        $subject = $request->subject;
    
        $content = $request->content;
        $ten = $request->khachhang_ten;
        Session::put('subject', $subject);
        Session::put('content', $content);
        Session::put('mailgui', $email_nguoigui);
        Session::put('tengui', $ten);
        $new_mail = new contact();
        Mail::to($emails)->send($new_mail);
        return Redirect::to('/contact');
    }

  
}

  

        // DOi mk
        public function change_pass($id){
            $this->AuthenLogin();
            Session::forget('admin_id');
            return view('admin_change_pass')->with('id',$id);
        }

        public function confirm_change_pass(Request $request){
            $old = $request->old;
      $new = $request->new;
      $confirm= $request->confirm;
      $id = $request->id;
      $mk = DB::table('admin')->where('admin_id',$id)->value('admin_password');
      if($old != $mk){
        Session::put('message','Mật khẩu cũ không chính xác');
        return $this->change_pass($id);
           
      }
      if(strlen($new) < 5){
        Session::put('message','Mật khẩu mới phải từ 5 kí tự trở lên');
        return $this->change_pass($id);
           
      }
      if($old == $new){
        Session::put('message','Mật khẩu mới phải khác mật khẩu cũ');
        return $this->change_pass($id);
           
      }
      else {
        if($new != $confirm){
            Session::put('message','Mật khẩu xác nhận không trùng khớp');
            return $this->change_pass($id);
           
        }
        else {

            DB::table('admin')->where('admin_id',$id)->update(['admin_password'=>md5($new)]);
            Session::put('message','Thay đổi mật khẩu thành công');
            return Redirect('/admin');
           
        }
      }
      

        }

}
