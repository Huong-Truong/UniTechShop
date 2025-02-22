<?php

namespace App\Http\Controllers;
use App\Models\Classify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();

class ClassifyController extends Controller
{
    public function AuthenLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return  Redirect::to('admin.dashboard');
        }else{
           return Redirect::to('admin')->send(); ## hàm send() có thể không cần thiết
        }
    }
    public function add_classify_product ()
    {
        $this->AuthenLogin();
        return view('admin.classify.add_classify_product');
    }

    public function all_classify_product ()
    {
        $this->AuthenLogin();
       $all_classify = Classify::orderBy('phanloai_id','desc')->get();
       // $all_classify = DB::table('phanloaisp')->get(); ## lấy tấy cả dữ liêu
        $manger_classify = view ('admin.classify.all_classify_product')->with('all_classify', $all_classify);
        return view('admin_layout')->with('admin.all_classify_product',$manger_classify); ## gom lại hiện chung

    }
    public function save_classify_product (Request $request)    
    {
        $this->AuthenLogin();
        $classify = new Classify();
        $data = $request->all();
       // $data['phanloai_ten'] = $request->classify_name;
        $classify->phanloai_ten = $data['classify_name'];
        /*insert vào bảng*/
        //DB::table('phanloaisp')->insert($data);
        $classify->save();
        Session::put('message','Thêm phân loại sản phẩm mới thành công!');
        return Redirect::to('add-classify-product'); ## Khi thêm thành công rồi thì trả lại về thêm danh mục sản phẩm
    }


    public function edit_classify_product($classify_id){
        $this->AuthenLogin();
        $classify = Classify::where('phanloai_id',$classify_id)->get();
       //  $classify = DB::table('phanloaisp')->where('phanloai_id', $classify_id)->get();
        $manger_classify = view ('admin.classify.edit_classify_product')->with('edit_classify', $classify);
        return view('admin_layout')->with('admin.classify.edit_classify_product',$manger_classify); ## gom lại hiện chung
    }


    public function delete_classify_product($classify_id){
        $this->AuthenLogin();
        $classify = Classify::find( $classify_id );
        $classify->delete();
       // DB::table('phanloaisp')->where('phanloai_id', $classify_id)->delete();
        Session::put('message','Xóa phân phân loại sản phẩm thành công');
        return Redirect::to('all-classify-product'); 
    }

    public function update_classify_product(Request $request,$classify_id){
        $this->AuthenLogin();
        // $data = array();
        // $data['phanloai_ten'] = $request->classify_name;
        $classify = Classify::find( $classify_id );
        $data = $request->all();
        $classify->phanloai_ten = $data['classify_name'];
       // DB::table('phanloaisp')->where('phanloai_id', $classify_id)->update($data);
         $classify->save();
        Session::put('message','Cập nhật phân loại sản phẩm thành công');
        return Redirect::to('all-classify-product'); 
    }

    public function search_classify_product(Request $request){
        $this->AuthenLogin();
        $key_search = $request->key_search;
        $all_classify = DB::table('phanloaisp')->where('phanloai_ten','like','%'.$key_search.'%')->get(); ## lấy tấy cả dữ liêu

         return view('admin.classify.all_classify_product')->with('all_classify', $all_classify);

    }
    
   
    // end function admin

}
