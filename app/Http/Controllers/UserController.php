<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Mail;
use App\Mail\Send;
use App\Mail\contact;
use App\Mail\ForgotPass;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();


class UserController extends Controller
{
    //

    public function forgot_user(){
        return view('forgot_pass');
    }

    public function review_user(Request $request) {
   
        $email = $request->email;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$%&';
        $length = 6;
        $characterLength = strlen($characters) -1;
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $characterLength - 1)];
        }
        
        $new_pass = $randomPassword;
        $data['khachhang_matkhau'] = $new_pass;

        $user_email = DB::table('khachhang')->where('khachhang_email', $email)->first();
        if($user_email){
            $new_mail = new ForgotPass();
            DB::table('khachhang')->where('khachhang_email', $email)->update($data);
            Session::put('message', 'Mật khẩu mới đã được gửi đến mail của bạn');
            Session::put('new_pass',$new_pass);
            Mail::to($email)->send($new_mail);
            return Redirect::to('/login-checkout');
        }
        else {
            Session::put('message', 'Tài khoản không tồn tại, vui lòng nhập lại');
            return Redirect::to('/forgot-user');
        }
    
      
       
    }

    public function change_pass(Request $request){
      $old = $request->old_password;
      $new = $request->new_password;
      $confirm= $request->confirm_password;
      $kh_id = $request->khachhang_id;
      $mk = DB::table('khachhang')->where('khachhang_id',$kh_id)->value('khachhang_matkhau');
      if($old != $mk){
        Session::put('message','Mật khẩu cũ không chính xác');
        return Redirect::to('/account');
      }
      if(strlen($new) < 5){
        Session::put('message','Mật khẩu mới phải từ 5 kí tự trở lên');
        return Redirect::to('/account');
      }
      if($old == $new){
        Session::put('message','Mật khẩu mới phải khác mật khẩu cũ');
        return Redirect::to('/account');
      }
      else {
        if($new != $confirm){
            Session::put('message','Mật khẩu xác nhận không trùng khớp');
            return Redirect::to('/account');
        }
        else {
            DB::table('khachhang')->where('khachhang_id',$kh_id)->update(['khachhang_matkhau'=>$new]);
            Session::put('message','Thay đổi mật khẩu thành công');
            return Redirect::to('/account');
           
        }
      }
      

    }

}
