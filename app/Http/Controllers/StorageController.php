<?php


namespace App\Http\Controllers;
use App\Models\NhaCungCap;
use App\Models\Storage;
use App\Models\TonKho;
use App\Models\HoaDonNhap;

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
    public function unactive_product_storage(){
        $this->AuthenLogin();
        $sp =   DB::table('sanpham')->get();
        foreach($sp as $key => $value){
            $sl_kho = DB::table('tonkho')->where('sanpham_id', $value->sanpham_id)->sum('tonkho_soluong');
            if($sl_kho == 0){
                DB::table('sanpham')->where('sanpham_id', $value->sanpham_id)->update(['sanpham_trangthai' => 0]);
            }else{
                DB::table('sanpham')->where('sanpham_id', $value->sanpham_id)->update(['sanpham_trangthai' => 1]);
            }
        }    
        Session::put('success','Cập nhật hiển thị thành công');
        return redirect()->back();
    }
    public function AuthenLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return  Redirect::to('admin.dashboard');
        }else{
           return Redirect::to('admin')->send(); ## hàm send() có thể không cần thiết
        }
    }
    public function store(){
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

    public function delete_store($sanpham_id,$kho_id){
        $this->AuthenLogin();  
        $soluong['tonkho_soluong'] = 0;
          $store = DB::table('tonkho')
          ->where('sanpham_id', $sanpham_id)
          ->where('kho_id', $kho_id)->update($soluong);
        return $this->store();
     
    }

    public function nhapkho($kho_id){

        $this->AuthenLogin();
        $ncungcap = NhaCungCap::get();
        $kho = Storage::find($kho_id);
        $hdn = HoaDonNhap::join('nhacungcap','nhacungcap.nhacungcap_id','=','hoadonnhap.nhacungcap_id')
        ->where('kho_id',$kho_id)
        ->get();
        
        return   view ('admin.storage.nhapkho')
        ->with('ncungcap', $ncungcap )
        ->with('kho',$kho)
        ->with('hdn',$hdn);
    }

    public function chitiet_hdn($hdn_id){

        $chitiet = DB::table('chitiethoadonnhap')
        ->join('sanpham','sanpham.sanpham_id','=','chitiethoadonnhap.sanpham_id')
        ->join('hoadonnhap','hoadonnhap.hdn_id','=','chitiethoadonnhap.hdn_id')
       
        ->where('chitiethoadonnhap.hdn_id',$hdn_id)->get();


        return view('admin.storage.chitiet_hdn')
        ->with('chitiet',$chitiet)
        ->with('hdn_id',$hdn_id);
    }


    public function add_hdn($kho_id){


    }
    
    public function import_hdn(Request $request, $kho_id)
    {
        $this->AuthenLogin();
       
    
        if (!$request->hasFile('fileToUpload')) {
            Session::put('message', 'Chưa có file nào được chọn');
            return Redirect::to('/nhapkho/' . $kho_id);
        }
    
        $file = $request->file('fileToUpload');
        $fileType = strtolower($file->getClientOriginalExtension());
    
        if ($fileType != 'csv') {
            Session::put('message', 'Chỉ chấp nhận csv');
            return Redirect::to('/all-classify-product');
        }
    
        $target_dir = 'excel/';
        $target_file = $target_dir . $file->getClientOriginalName();
        $file->move($target_dir, $file->getClientOriginalName());
    
        $maxID_hdn = HoaDonNhap::max('hdn_id') ?? 0;
    
        $hdn = new HoaDonNhap();
        $hdn->hdn_id = $maxID_hdn + 1;
        $hdn->hdn_ngay = date('y-m-d');
        $hdn->nhacungcap_id = $request->nhacungcap;
        
        $hdn->kho_id = $kho_id;
        $tongtien = 0;
     
    
        if (($handle = fopen($target_file, 'r')) !== FALSE) {
            fgetcsv($handle); // Skip header row
    
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $data = array_map(function($value) {
                    return mb_convert_encoding($value, 'UTF-8', 'auto');
                }, $data);
                $tongtien += (int)$data[1]*(int)$data[2];
                  //  Cập nhật vô kho
                  if( $tonkho = DB::table('tonkho')->where('kho_id',$kho_id)
                  ->where('sanpham_id',$data[0])->first()){
                    $ton = array();
                    $ton['tonkho_soluong'] = $data[2];
                    DB::table('tonkho')->where('kho_id',$kho_id)
                    ->where('sanpham_id',$data[0])->update($ton);
                }
                else {
                    $ton = array();
                    $ton['kho_id'] = $kho_id;
                    $ton['sanpham_id'] = $data[0];
                    $ton['tonkho_soluong'] = $data[2];
                    DB::table('tonkho')->insert($ton);
                }
                

                // Xử lú chi tiết nhập
                $chitiet = [
                    'sanpham_id' => $data[0],
                    'dongia' => $data[1],
                    'hdn_soluong' => $data[2],
                    'hdn_id' => $maxID_hdn + 1
                ];

                DB::table('sanpham')->where('sanpham_id', $data[0])->update(['sanpham_trangthai' => 1]);

                if (!DB::table('chitiethoadonnhap')->insert($chitiet)) {
                    Session::put('message', 'File CSV không khớp');
                    fclose($handle);
                    return Redirect::to('/nhapkho/' . $kho_id);
                }
            }
            fclose($handle);
            $hdn->hdn_tongtien = $tongtien;
            $hdn->save();
            Session::put('message', 'Thêm thành công');
        } else {
            Session::put('message', 'Không thể mở tệp CSV');
        }
        $sp =   DB::table('sanpham')->get();


        return Redirect::to('/nhapkho/' . $kho_id);
    }

  
    

}
