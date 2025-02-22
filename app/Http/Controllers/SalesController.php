<?php


namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\KhuyenMai;
use App\Models\ThongTinKhuyenMai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();

class SalesController extends Controller
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
    public function add_sales ()
    {
        $this->AuthenLogin();
        $sale = KhuyenMai::select('km_donvi')
        ->groupBy('km_donvi')
        ->get();
        return view('admin.sales.add_sales')->with('sales', $sale);
    }
    public function save_sales(Request $request)    
    {
        $this->AuthenLogin();
        $data = $request->all();
        $sale = new KhuyenMai();
        $sale->km_gia = $data['sale_price'];
        $sale->km_donvi = $data['sale_unit'];
        $sale->km_mota = $data['sale_content'];
        $dv =  $data['sale_unit'];
        $gia = (int)$data['sale_price'];
        // $data = array();
        //  $data['km_gia'] = (int)$request->sale_price;
        //  $data['km_donvi'] = $request->sale_unit;
        //  $data['km_mota'] = $request->sale_content;
         if($gia != 0){
            if( $dv == '%'){
                if($gia >=100){
                    Session::put('message','Phần trăm nhập vào tối đa 99%');
                    return Redirect::to('add-sales'); 
                }
            }
            $sale->save();
            // DB::table('khuyenmai')->insert($data);
            return Redirect::to('all-sales'); 
         }
         else{
            Session::put('message','Giá trị nhập vào không hợp lệ');
            return Redirect::to('add-sales'); 
         }
        /*insert vào bảng*/
       
    }
    public function all_sales(){
        $this->AuthenLogin();
        $all_sales = KhuyenMai::orderBy('km_id','desc')->get();
        $manger_sales = view ('admin.sales.all_sales')->with('all_sales', $all_sales);
        return view('admin_layout')->with('admin.all_sales',$manger_sales); ## gom lại hiện chung
    }

    public function delete_sales($sale_id){
        $this->AuthenLogin();
        $sale = KhuyenMai::find($sale_id);
        $sale->delete();
        return Redirect::to('all-sales'); 
    }

    public function set_sale($product_id)
    {
        $this->AuthenLogin();
        $sale = KhuyenMai::orderBy('km_gia','desc')
        ->get();
        $sp = Product::find($product_id);
        $info_sale = ThongTinKhuyenMai::where('sanpham_id', $product_id)->first();
       
            return view('admin.sales.set_sales')
            ->with('sales', $sale)
            ->with('info_sale',$info_sale)
            ->with('product_id', $product_id)
            ->with('sp',$sp);
        
        
       
    }

    public function save_set_sale(Request $request,$product_id){
        $this->AuthenLogin();
       // $data = array();
        $data['sanpham_id'] = $product_id;
        $data['km_id'] = $request->sale_id;
        $data['ngaybatdau'] = $request->start_date;
        $data['ngayketthuc'] = $request->end_date;
        if( $data['ngaybatdau'] <  $data['ngayketthuc']){
            if(DB::table('thongtinkhuyenmai')->where('sanpham_id',$product_id)->first()){
                DB::table('thongtinkhuyenmai')->update($data);
                Session::put('message','Thiết lập thành công');
                return Redirect::to('all-product'); 
            }
            else {
                DB::table('thongtinkhuyenmai')->insert($data);
                Session::put('message','Thiết lập thành công');
                return Redirect::to('all-product'); 
            }
        }
        else {
            Session::put('message','Ngày kết thúc phải lớn hơn ngày bắt đầu');
            return Redirect::to('set-sale/'.$product_id); 
        }
       
      
    }
  
}
