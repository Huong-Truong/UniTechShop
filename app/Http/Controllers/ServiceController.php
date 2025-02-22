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
    public function save_service(Request $request)    
    {
        $this->AuthenLogin();
        $data = $request->all();
        $service = new Service();
        $service->dv_ten = $data['service_name'];
        $service->save();
        return Redirect::to('all-service'); 
    }
       
    
    public function all_service(){
        $this->AuthenLogin();
        $all_service = Service::orderBy('dv_id','desc')->get();
        $manger_service = view ('admin.service.all_service')->with('all_service', $all_service);
        return view('admin_layout')->with('admin.all_service',$manger_service); ## gom lại hiện chung
    }

    public function delete_service($service_id){
        $this->AuthenLogin();
        $service = Service::find($service_id);
        $service->delete();
        return Redirect::to('all-service'); 
    }

    public function set_service($product_id)
    {
        $this->AuthenLogin();
        $srv = Service::orderBy('km_gia','desc')
        ->get();
        $sp = Product::find($product_id);
        $priceSrv = PriceService::where('sanpham_id', $product_id)->first();
            return view('admin.sales.set_sales')
            ->with('sales', $sale)
            ->with('info_sale',$info_sale)
            ->with('product_id', $product_id)
            ->with('sp',$sp);
        
        
       
    }

    public function save_set_service(Request $request,$product_id){
        $this->AuthenLogin();
    $dv_ids = $request->input('dv_id');
    $giadichvus = $request->input('giadichvu');

    // Duyệt qua từng dịch vụ và giá dịch vụ
    foreach ($dv_ids as $index => $dv_id) {
        // Loại bỏ định dạng tiền tệ
        $giadichvu = preg_replace('/[^\d]/', '', $giadichvus[$index]);

        // Kiểm tra xem bản ghi đã tồn tại chưa
        $existingRecord = DB::table('giadichvu')
            ->where('sanpham_id', $product_id)
            ->where('dv_id', $dv_id)
            ->first();

        if ($existingRecord) {
            // Nếu đã tồn tại, thực hiện update
            DB::table('giadichvu')
                ->where('sanpham_id', $product_id)
                ->where('dv_id', $dv_id)
                ->update(['giadichvu' => $giadichvu]);
        } else {
             // Nếu chưa tồn tại, thực hiện insert
            if ($giadichvu){
                DB::table('giadichvu')->insert([
                    'sanpham_id' => $product_id,
                    'dv_id' => $dv_id,
                    'giadichvu' => $giadichvu
                ]);
            }
           
          
        }
    }

    return Redirect::to('edit-other-info-product/'.$product_id); 


    }
  
}
