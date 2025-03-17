<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Service;
use App\Models\PriceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();

class ServiceController extends Controller
{
    //
    //
    public function AuthenLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return  Redirect::to('admin.dashboard');
        }else{
           return Redirect::to('admin')->send(); ## hàm send() có thể không cần thiết
        }
    }
    public function add_service ()
    {
        $this->AuthenLogin();
        return view('admin.service.add_service');
    }
    
    public function all_service(){
        $this->AuthenLogin();
        $all_service = Service::orderBy('dv_id','desc')->get();
        $manger_service = view ('admin.service.all_service')->with('all_service', $all_service);
        return view('admin_layout')->with('admin.all_service',$manger_service); ## gom lại hiện chung
    }
    public function save_service(Request $request)    
    {
        $this->AuthenLogin();
        $data = $request->all();
        $service = new Service();
        $service->dv_ten = $data['service_name'];
        $service->save();
        
        Session::put('message', 'Thêm dịch vụ thành công!');
        return Redirect::to('all-service'); 
    }
    
    public function delete_service($service_id){
        $this->AuthenLogin();
        $service = Service::find($service_id);
        $service->delete();
        
        Session::put('message', 'Xóa dịch vụ thành công!');
        return Redirect::to('all-service'); 
    }
    
    public function save_set_service(Request $request, $product_id){
        $this->AuthenLogin();
        $dv_ids = $request->input('dv_id');
        $giadichvus = $request->input('giadichvu');
       
    
        foreach ($dv_ids as $index => $dv_id) {
            $giadichvu = preg_replace('/[^\d]/', '', $giadichvus[$index]);

            if( (int)$giadichvus[$index] == 0 && $giadichvus[$index] !='Chưa thiết lập' ){
                Session::put('message', 'Giá dịch vụ nhập vào không hợp lệ!');
                return Redirect::to('/edit-other-info-product/'.$product_id);
            }
            
            $existingRecord = DB::table('giadichvu')
                ->where('sanpham_id', $product_id)
                ->where('dv_id', $dv_id)
                ->first();
    
            if ($existingRecord) {
                DB::table('giadichvu')
                    ->where('sanpham_id', $product_id)
                    ->where('dv_id', $dv_id)
                    ->update(['giadichvu' => $giadichvu]);
            } else {
                if ($giadichvu){
                    DB::table('giadichvu')->insert([
                        'sanpham_id' => $product_id,
                        'dv_id' => $dv_id,
                        'giadichvu' => $giadichvu
                    ]);
                }
            }
        }
    
        Session::put('message', 'Cập nhật giá dịch vụ thành công!');
        return Redirect::to('edit-other-info-product/'.$product_id); 
    }
  
}
