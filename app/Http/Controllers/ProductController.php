<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\HDSD;
use App\Models\Service;
use App\Models\PriceService;
use App\Models\BaoHanh;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();


class ProductController extends Controller
{
    
    public function AuthenLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return  Redirect::to('admin.dashboard');
        }else{
           return Redirect::to('admin')->send(); ## hàm send() có thể không cần thiết
        }
    }
    public function add_product ()
    {
        $this->AuthenLogin();
        
       $cate_product = Category::selectRaw('MIN(danhmuc_id) as danhmuc_id, danhmuc_ten')
        ->groupBy('danhmuc_ten')
        ->get();
        $brand_product = Brand::selectRaw('MIN(hang_id) as hang_id, hang_ten')
        ->groupBy('hang_ten')
        ->get();
        $bh = BaoHanh::orderBy('baohanh_thoigian','desc')->get();

       return view ('admin.product.add_product')
       ->with('cate_product', $cate_product)
       ->with('brand_product', $brand_product)
       ->with('baohanh',$bh);
 
    }

    public function all_product ()
    {
        $this->AuthenLogin();
        $all = Product::join('danhmuc', 'danhmuc.danhmuc_id', '=', 'sanpham.danhmuc_id')
        ->join('hangsanpham', 'hangsanpham.hang_id', '=', 'sanpham.hang_id')
        ->select('sanpham.*', 'danhmuc.danhmuc_ten', 'hangsanpham.hang_ten')
        ->orderBy('sanpham_id','desc') 
        ->get(); // Thêm phương thức get() để lấy tất cả dữ liệu
        
        $category = Category::orderBy('danhmuc_ten','desc')->get();
        $brand = Brand::orderBy('hang_ten','desc')->get();

        $manger = view ('admin.product.all_product')->with('all', $all)
        ->with('category',$category)
        ->with('brand',$brand);
        return view('admin_layout')->with('admin.product.all_product',$manger); ## gom lại hiện chung

    }

    public function save_product (Request $request)    
    {
        $this->AuthenLogin();
        // Lấy ra id lớn nhất
        $maxId = DB::table('sanpham')->max('sanpham_id') + 1;
        // Lấy ra all dữ liệu 
        $data = $request->all();

       // Bảng HDSD
        $hdsd = new HDSD();
        $hdsd->sanpham_id = $maxId;
        $hdsd->hdsd_mota = "Chưa có";
        $hdsd->hdsd_video = "Chưa có";

        // Bảng SP
        $sp = new Product();
        $sp->sanpham_ten = $data['product_name'];
        $sp->danhmuc_id = $data['category'];
        $sp->hang_id = $data['brand'];
        $sp->sanpham_mota = $data['product_content'];
        $sp->sanpham_gia = $data['product_price'];
        $sp->sanpham_trangthai = $data['product_status'];
        $sp->sanpham_thongso = $data['product_specificate'];
        $sp->sanpham_xuatxu = $data['product_country'];
        $sp->baohanh_id = $data['baohanh'];
        $get_image_file = $request->file('product_image');


        if($get_image_file){

            $new_image = 'sp'.$maxId.'.'.$get_image_file->getClientOriginalExtension();
            // Di chuyển tệp tin đến thư mục đích
            $get_image_file->move('img/sp'.$maxId , $new_image);
            
            // Lưu thông tin ảnh vào cơ sở dữ liệu
            $sp->sanpham_hinhanh = $new_image;
           // insert vô sanpham
           $sp->save();
           // insert vô hdsd
           $hdsd->save();
            // Hiển thị thông báo thành công và chuyển hướng
            Session::put('message', 'Thêm sản phẩm mới thành công!');
            return Redirect::to('all-product');
        }else{
             // Lưu thông tin ảnh vào cơ sở dữ liệu
             $sp->sanpham_hinhanh = '';
            // insert vô sanpham
            $sp->save();
            // insert vô hdsd
            $hdsd->save();
            // Hiển thị thông báo thành công và chuyển hướng
            Session::put('message', 'Thêm sản phẩm mới thành công!');
            return Redirect::to('all-product');
        }

        

        /*
            $data['product_name'] : tên của cột trong database
            $request->product_product_name: tên của name lấy bên save
        */
        /*insert vào bảng*/
       
    }


    public function unactive_product($product_id){
        $this->AuthenLogin();
        DB::table('sanpham')->where('sanpham_id', $product_id)->update(['sanpham_trangthai' => 0]);
        // Session::put('message','Cập nhật hiển thị thành công');
        return Redirect::to('all-product'); 
    }

    public function active_product($product_id){
        $this->AuthenLogin();
        DB::table('sanpham')->where('sanpham_id', $product_id)->update(['sanpham_trangthai' => 1]);
        // Session::put('message','Cập nhật hiển thị thành công');
        return Redirect::to('all-product'); 
    }

    public function edit_product($product_id)
{
    $this->AuthenLogin();
    $cate_product = Category::orderBy('danhmuc_id', 'desc')->get();
    $brd_product = Brand::orderBy('hang_id', 'desc')->get();
    $product = Product::where('sanpham_id', $product_id)->first();
    $bh = BaoHanh::orderBy('baohanh_thoigian','desc')->get();
    return view('admin.product.edit_product')
        ->with('edit_product', $product)
        ->with('cate_product', $cate_product)
        ->with('brand_product', $brd_product)
        ->with('baohanh', $bh);
}



    public function delete_product($product_id){
        $this->AuthenLogin();
        $pro = Product::find( $product_id );
       
        $directoryPath = "img/sp$product_id";

        if (File::exists($directoryPath)) {
            File::deleteDirectory($directoryPath);
        } 
        $pro->delete();
        Session::put('message','Xóa sản phẩm thành công');
        return Redirect::to('all-product'); 
    }

    public function update_product(Request $request, $product_id)
    {
        $this->AuthenLogin();
        $data = array();
        $data['sanpham_ten'] = $request->product_name;
        $data['sanpham_gia'] = $request->product_price;
        $data['sanpham_mota'] = $request->product_content;
        $data['danhmuc_id'] = $request->category;
        $data['sanpham_thongso'] = $request->product_specificate;
        $data['sanpham_xuatxu'] = $request->product_xuatxu;
        $data['hang_id'] = $request->brand;
        $data['baohanh_id'] = $request->baohanh;
        $product = DB::table('sanpham')->where('sanpham_id', $product_id)->first();
        $get_image_file = $request->file('product_image');

       
        if($get_image_file){
            
            $new_image = 'sp'.$product_id.'.'.$get_image_file->getClientOriginalExtension();
            
            // Di chuyển tệp tin đến thư mục đích
            $get_image_file->move('img/sp'.$product_id, $new_image);
            
            // Lưu thông tin ảnh vào cơ sở dữ liệu
            $data['sanpham_hinhanh'] = $new_image;
            
        }
            
        DB::table('sanpham')->where('sanpham_id', $product_id)->update($data);
        Session::put('message', 'Cập nhật sản phẩm thành công!');
      
        return Redirect::to('all-product');
    }
    // Hàm hdsd
    
    public function edit_other_info_product($product_id)
{
        $this->AuthenLogin();

        $product = Product::find($product_id);
        $hdsd = HDSD::where('sanpham_id', $product_id)->get();
    //  $sp = Product::find($product_id);
        
        $priceSrv = DB::table('giadichvu')
        ->where('sanpham_id', $product_id)
        ->orderBy('dv_id', 'desc')
        ->get();

        $srv = DB::table('dichvukemtheo')
        ->orderBy('dv_id', 'desc')
        ->get();

    return view('admin.product.edit_other_info_product')
        ->with('hdsd', $hdsd)
        ->with('product', $product)
        ->with('service', $srv)
        ->with('priceSrv', $priceSrv);



  
}

public function update_other_info_product(Request $request,$product_id){
    $this->AuthenLogin();
    $data = $request->all();

    $hdsd = HDSD::find($product_id);
    $hdsd->HDSD_mota = $data['hdsd_mota'];
    $hdsd->HDSD_video = $data['hdsd_video'];
     $hdsd->save();

    // Session::put('message','Cập nhật thành công');
    return Redirect::to('edit-other-info-product/'.$product_id); 
}

public function import_product(Request $request)
    {
        // Kiểm tra xem tệp có được tải lên hay không
        if ($request->hasFile('fileToUpload')) {
            $file = $request->file('fileToUpload');
            
            $fileType = strtolower($file->getClientOriginalExtension());
    
            // Kiểm tra loại tệp
            if ($fileType != 'csv') {
                Session::put('message', 'Chỉ chấp nhận csv');
                return Redirect::to('/all-product');
            }
    
            // Di chuyển tệp đến thư mục lưu trữ
            $target_dir = 'excel/';
            $target_file = $target_dir . $file->getClientOriginalName();
            $file->move($target_dir, $file->getClientOriginalName());

            // Lấy ra id lớn nhất
                $maxId = DB::table('sanpham')->max('sanpham_id') ;
                $id_hdsd = $maxId  ;

            
    
            // Đọc và xử lý tệp CSV
            if (($handle = fopen($target_file, 'r')) !== FALSE) {
                fgetcsv($handle); // Bỏ qua dòng tiêu đề
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    $maxId = DB::table('sanpham')->max('sanpham_id') + 1;
                    $sp = new Product();
                    $sp->sanpham_ten = $data[0];
                    $sp->hang_id = $data[1];
                    $sp->danhmuc_id = $data[2];
                    $sp->sanpham_gia = $data[3];
                    $sp->sanpham_hinhanh = $data[4];
                    $sp->sanpham_mota = $data[5];
                    $sp->sanpham_trangthai = 1;
                    $sp->baohanh_id = 1;
                    if(!$sp->save()){
                        Session::put('message','File CSV không khớp');
                    }
                    else {
                           // Bảng HDSD
                    $hdsd = new HDSD();
                    $hdsd->sanpham_id = $maxId;
                    $hdsd->hdsd_mota = "Chưa có";
                    $hdsd->hdsd_video = "Chưa có"; 
                 
                    $hdsd->save();
                    }
                }
                fclose($handle);
                Session::put('message', 'Thêm thành công');
            } else {
                Session::put('message', 'Không thể mở tệp CSV');
            }
        } else {
            Session::put('message', 'Chưa file nào được chọn');
        }
    
        return Redirect::to('/all-product');
    }
    // end admin

    ## hiện sản phẩm trên trang "SẢN PHẨM"

    public function show_product(){

        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get();
        $product = DB::table('sanpham')->where('sanpham_trangthai', 1)->orderby('sanpham_id', 'desc')->paginate(9);
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
        return view('pages.product.shop')->with('danhmuc', $cate_product)->with('sanpham', $product)->with('phanloai', $phanloai)->with('hang', $brand);
    }

    public function show_details_product($product_id){
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); ## lấy id category
        $brd_product = DB::table('brand')->where('brand_status', 1)->orderby('brand_id', 'desc')->get(); ## lấy id category
      
        $details_product = DB::table('product')
        ->join('category', 'category.category_id', '=', 'product.category_id')
        ->join('brand', 'brand.brand_id', '=', 'product.brand_id')
        ->where('product.product_id', $product_id)->first();

         $category_id = $details_product->category_id;
    
        $relate_product = DB::table('product')
        ->join('category', 'category.category_id', '=', 'product.category_id')
        ->join('brand', 'brand.brand_id', '=', 'product.brand_id')
        ->where('product.category_id', $category_id)->whereNotIn('product.product_id', [$product_id] )->get();
                                                                                                ## phải có mảng

        return view('pages.product.show_details')->with('relate', $relate_product)->with('product', $details_product)->with('danhmuc', $cate_product)->with('brand', $brd_product);
    }


    public function show_chitiet_sanpham($sanpham_id){
    
 
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); // lấy id category
        $product = DB::table('sanpham')->where('sanpham_id', $sanpham_id)->
        join('danhmuc','danhmuc.danhmuc_id', '=', 'sanpham.danhmuc_id')->
        join('hangsanpham', 'hangsanpham.hang_id', '=', 'sanpham.hang_id')->first();
        $hinhanh = DB::table('hinhanh')->where('sanpham_id', $product->sanpham_id)->get();
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        $baohanh = DB::table('baohanh')->where('baohanh_id', $product->baohanh_id)->first();
        $dichvu = DB::table('giadichvu')->join('dichvukemtheo', 'giadichvu.dv_id', '=', 'dichvukemtheo.dv_id')->where('sanpham_id', $sanpham_id)->get();
        $today = Date('Y-m-d');
        $khuyenmai = DB::table('thongtinkhuyenmai')
        ->join('khuyenmai','thongtinkhuyenmai.km_id', '=', 'khuyenmai.km_id')->where('thongtinkhuyenmai.sanpham_id', $sanpham_id)
        ->whereDate('thongtinkhuyenmai.ngaybatdau' ,'<=', $today)
        ->whereDate('thongtinkhuyenmai.ngayketthuc', '>=', $today)->
        first();
           ## sản phẩm tương tự
        ## lấy danh mục 
        
        $hdsd = DB::table('hdsd')->where('sanpham_id',$sanpham_id)->get();
     
        $product_rela = DB::table('sanpham')
        ->where('danhmuc_id', $product->danhmuc_id)
        ->whereNotIn('sanpham_id', [$product->sanpham_id])
        ->limit(4)
        ->get();
        if($khuyenmai){
            if($khuyenmai->km_donvi == '%'){
                $update_gia = $product->sanpham_gia - ($product->sanpham_gia * $khuyenmai->km_gia)/100;
               
            }else if($khuyenmai->km_donvi == 'VND'){
                $update_gia = $product->sanpham_gia - $khuyenmai->km_gia;
            }
            Session::put('gia_update', $update_gia);
            return view('pages.product.product_details')->with('baohanh', $baohanh)->with('dichvu', $dichvu)->with('hdsd', $hdsd)->with('phanloai', $phanloai)->with('price_update', $update_gia)->with('hinhanh', $hinhanh)->with('danhmuc', $cate_product)->with('sanpham', $product)->with('sanpham_tuongtu', $product_rela);
        }else{
            return view('pages.product.product_details')->with('baohanh', $baohanh)->with('dichvu', $dichvu)->with('hdsd', $hdsd)->with('phanloai', $phanloai)->with('hinhanh', $hinhanh)->with('danhmuc', $cate_product)->with('sanpham', $product)->with('sanpham_tuongtu', $product_rela);

           
        }
    }

    public function filter_by_cate (Request $request)
    {
        $this->AuthenLogin();
        $cate_id = $request->category;
        if($cate_id == 'all'){
            return Redirect('/all-product');
        }
        $all = Product::join('danhmuc', 'danhmuc.danhmuc_id', '=', 'sanpham.danhmuc_id')
        ->join('hangsanpham', 'hangsanpham.hang_id', '=', 'sanpham.hang_id')
        ->select('sanpham.*', 'danhmuc.danhmuc_ten', 'hangsanpham.hang_ten')
        ->where('sanpham.danhmuc_id', $cate_id)
        ->orderBy('sanpham_id','desc') 
        ->get(); // Thêm phương thức get() để lấy tất cả dữ liệu
        
        $category = Category::orderBy('danhmuc_ten','desc')->get();
        $brand = Brand::orderBy('hang_ten','desc')->get();

        $manger = view ('admin.product.all_product')->with('all', $all)
        ->with('category',$category)
        ->with('brand',$brand);
        return view('admin_layout')->with('admin.product.all_product',$manger); ## gom lại hiện chung

    }

    public function filter_by_brand (Request $request)
    {
        $this->AuthenLogin();
        $brand_id = $request->brand;
        if($brand_id == 'all'){
            return Redirect('/all-product');
        }
        $all = Product::join('danhmuc', 'danhmuc.danhmuc_id', '=', 'sanpham.danhmuc_id')
        ->join('hangsanpham', 'hangsanpham.hang_id', '=', 'sanpham.hang_id')
        ->select('sanpham.*', 'danhmuc.danhmuc_ten', 'hangsanpham.hang_ten')
        ->where('sanpham.hang_id', $brand_id)
        ->orderBy('sanpham_id','desc') 
        ->get(); // Thêm phương thức get() để lấy tất cả dữ liệu
        
        $category = Category::orderBy('danhmuc_ten','desc')->get();
        $brand = Brand::orderBy('hang_ten','desc')->get();

        $manger = view ('admin.product.all_product')->with('all', $all)
        ->with('category',$category)
        ->with('brand',$brand);
        return view('admin_layout')->with('admin.product.all_product',$manger); ## gom lại hiện chung

    }

    public function search_product(Request $request)
    {
        $this->AuthenLogin();
        $key = $request->key;
        $all = Product::join('danhmuc', 'danhmuc.danhmuc_id', '=', 'sanpham.danhmuc_id')
        ->join('hangsanpham', 'hangsanpham.hang_id', '=', 'sanpham.hang_id')
        ->select('sanpham.*', 'danhmuc.danhmuc_ten', 'hangsanpham.hang_ten')
        ->where('sanpham.sanpham_ten','like','%'.$key.'%')
        ->orderBy('sanpham_id','desc') 
        ->get(); // Thêm phương thức get() để lấy tất cả dữ liệu
        
        $category = Category::orderBy('danhmuc_ten','desc')->get();
        $brand = Brand::orderBy('hang_ten','desc')->get();

        $manger = view ('admin.product.all_product')->with('all', $all)
        ->with('category',$category)
        ->with('brand',$brand);
        return view('admin_layout')->with('admin.product.all_product',$manger); ## gom lại hiện chung

    }


}