<?php


namespace App\Http\Controllers;
use App\Models\Storage;
use App\Models\TonKho;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();
class StorageController extends Controller
{
    //
    public function AuthenLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return  Redirect::to('admin.dashboard');
        }else{
           return Redirect::to('admin')->send(); ## hàm send() có thể không cần thiết
        }
    }
    public function store(Request $request){
        $this->AuthenLogin();
        $id_begin = Storage::pluck('kho_id')->first();
        $name_begin = Storage::find($id_begin);
        $storage = Storage::get();
        $store = DB::table('tonkho')
        ->join('sanpham', 'sanpham.sanpham_id', '=', 'tonkho.sanpham_id')
        ->join('khohang', 'khohang.kho_id', '=', 'tonkho.kho_id')
        ->where('khohang.kho_id',$id_begin)
        ->orderBy('sanpham.sanpham_id', 'desc')
        ->get();
        
    
        return   view ('admin.storage.storage')
        ->with('store', $store)
        ->with('storage', $storage)
        ->with('kho',$name_begin);
    }

    public function fill_kho(Request $request){
        $this->AuthenLogin();
       $id_kho =  $request->kho;
       $kho = Storage::find($id_kho);
       $storage = Storage::get();
       $store = DB::table('tonkho')
       ->join('sanpham', 'sanpham.sanpham_id', '=', 'tonkho.sanpham_id')
       ->join('khohang', 'khohang.kho_id', '=', 'tonkho.kho_id')
       ->where('khohang.kho_id',$id_kho)
       ->orderBy('sanpham.sanpham_id', 'desc')
       ->get();
       
   
       return   view ('admin.storage.storage')
       ->with('store', $store)
       ->with('storage', $storage)
       ->with('kho', $kho);
    }

    public function search_kho(Request $request){
        $this->AuthenLogin();
        $id_kho = $request->id_kho;
        $kho = Storage::find($id_kho);
        $key = $request->key;
        $storage = Storage::get();
        $store = DB::table('tonkho')
        ->join('sanpham', 'sanpham.sanpham_id', '=', 'tonkho.sanpham_id')
        ->join('khohang', 'khohang.kho_id', '=', 'tonkho.kho_id')
        ->where('khohang.kho_id',$id_kho)
        ->where('sanpham.sanpham_ten','like','%'.$key.'%')
        ->orderBy('sanpham.sanpham_id', 'desc')
        ->get();
        
    
        return   view ('admin.storage.storage')
        ->with('store', $store)
        ->with('storage', $storage)
        ->with('kho', $kho);
     
    }
}
