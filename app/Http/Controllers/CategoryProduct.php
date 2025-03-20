<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Classify;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Brand;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect; ## trả về cái trang thành công hay thất bại
session_start();

class CategoryProduct extends Controller
{
    
    public function AuthenLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return  Redirect::to('admin.dashboard');
        }else{
           return Redirect::to('admin')->send(); ## hàm send() có thể không cần thiết
        }
    }
    public function add_category_product ()
    {
        $this->AuthenLogin();
        $classify_product = DB::table('phanloaisp')->orderby('phanloai_id', 'desc')->get(); ## lấy id 
        $classify_product = DB::table('phanloaisp')
    ->select(DB::raw('MIN(phanloai_id) as phanloai_id'), 'phanloai_ten')
    ->groupBy('phanloai_ten')
    ->get();
        return view('admin.category.add_category_product')->with('classify_product', $classify_product);
    }

    public function all_category_product ()
    {
        $this->AuthenLogin();

        // $all_category = DB::table('danhmuc')
        // ->join('phanloaisp', 'phanloaisp.phanloai_id', '=', 'danhmuc.phanloai_id')->get(); ## lấy tấy cả dữ liêu
         $all_category = Category::join('phanloaisp','phanloaisp.phanloai_id','=','danhmuc.phanloai_id')
         ->orderBy('danhmuc_id','desc')->get();
        $manger_category = view ('admin.category.all_category_product')->with('all_category', $all_category);
        return view('admin_layout')->with('admin.category.all_category_product',$manger_category); ## gom lại hiện chung

    }

    public function save_category_product (Request $request)    
    {
        $this->AuthenLogin();
        if(!$maxID = Classify::max('phanloai_id')) {
            $maxID = 0;
      }

        $data = $request->all();
        $category = new Category();
        $category->danhmuc_id = $maxID + 1;
        $category->danhmuc_ten = $data['danhmuc_ten'];
        $category->danhmuc_trangthai = $data['danhmuc_trangthai'];
        $category->phanloai_id   = $data['classify'];
      
        
        /*insert vào bảng*/
       // DB::table('danhmuc')->insert($data);
        $category->save();
        Session::put('message','Thêm danh mục sản phẩm mới thành công!');
        return Redirect::to('add-category-product'); ## Khi thêm thành công rồi thì trả lại về thêm danh mục sản phẩm
    }


    public function unactive_category_product($category_id){
        $this->AuthenLogin();
        DB::table('danhmuc')->where('danhmuc_id', $category_id)->update(['danhmuc_trangthai' => 0]);
        // Session::put('message','Cập nhật hiển thị thành công');
        return Redirect::to('all-category-product'); 
    }

    public function active_category_product($category_id){
        $this->AuthenLogin();
        DB::table('danhmuc')->where('danhmuc_id', $category_id)->update(['danhmuc_trangthai' => 1]);
        // Session::put('message','Cập nhật hiển thị thành công');
        return Redirect::to('all-category-product'); 
    }

    public function edit_category_product($category_id){
        $this->AuthenLogin();
        $category = Category::where('danhmuc_id', $category_id)->get();
        $classify = Classify::orderBy('phanloai_id','desc')->get();
        // $category = DB::table('danhmuc')->where('danhmuc_id', $category_id)->get();
        $manger_category = view ('admin.category.edit_category_product')
        ->with('edit_category', $category)
        ->with('classify',$classify);
        return view('admin_layout')->with('admin.category.edit_category_product',$manger_category); ## gom lại hiện chung
    }


    public function delete_category_product($category_id){
        $this->AuthenLogin();
        $checkCate = Product::where('danhmuc_id',$category_id)->count();
        if( $checkCate > 0){
            Session::put('message','Không thể xóa. Đang có '.$checkCate.' sản phẩm thuộc danh mục này');
            return Redirect::to('all-category-product'); 
        }
        $category = Category::find($category_id);
        $category->delete();
        // DB::table('danhmuc')->where('danhmuc_id', $category_id)->delete();
        Session::put('message','Xóa danh mục thành công');
        return Redirect::to('all-category-product'); 
    }

    public function update_category_product(Request $request,$category_id){
        $this->AuthenLogin();
        // $data = array();
        // $data['danhmuc_ten'] = $request->danhmuc_ten;
        $category = Category::find( $category_id );
        $data = $request->all();
        $category->danhmuc_ten = $data['danhmuc_ten'];
        $category->phanloai_id = $data['classify'];
        //DB::table('danhmuc')->where('danhmuc_id', $category_id)->update($data);
        $category->save();
        Session::put('message','Cập nhật danh mục thành công');
        return Redirect::to('all-category-product'); 
    }

    public function import_category(Request $request)
    {
        // Kiểm tra xem tệp có được tải lên hay không
        if ($request->hasFile('fileToUpload')) {
            $file = $request->file('fileToUpload');
            
            $fileType = strtolower($file->getClientOriginalExtension());
    
            // Kiểm tra loại tệp
            if ($fileType != 'csv') {
                Session::put('message', 'Chỉ chấp nhận csv');
                return Redirect::to('/all-category-product');
            }
    
            // Di chuyển tệp đến thư mục lưu trữ
            $target_dir = 'excel/';
            $target_file = $target_dir . $file->getClientOriginalName();
            $file->move($target_dir, $file->getClientOriginalName());
    
            // Đọc và xử lý tệp CSV
            if (($handle = fopen($target_file, 'r')) !== FALSE) {
                fgetcsv($handle); // Bỏ qua dòng tiêu đề
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                      // Chuyển đổi encoding của từng cột
                      $data = array_map(function($value) {
                        return mb_convert_encoding($value, 'UTF-8', 'auto');
                    }, $data);
                    if(!$maxID = Category::max('danhmuc_id')) {
                        $maxID = 0;
                  }
                    $cate = new Category();
                    $cate->danhmuc_id = $maxID + 1;
                    $cate->danhmuc_ten = $data[0];
                    $cate->phanloai_id = $data[1];
                    $cate->danhmuc_trangthai = 1;
                    $cate->save();
                    $maxID++;
                }
                fclose($handle);
                Session::put('message', 'Thêm thành công');
            } else {
                Session::put('message', 'Không thể mở tệp CSV');
            }
        } else {
            Session::put('message', 'Chưa file nào được chọn');
        }
    
        return Redirect::to('/all-category-product');
    }
    //  End function của admin


    public function show_category_home($category_id){
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); ## lấy id category
        $brd_product = DB::table('brand')->where('brand_status', 1)->orderby('brand_id', 'desc')->get(); ## lấy id category
        $all = DB::table('product')
        ->join('category', 'category_product.category_id', '=', 'product.category_id')
        ->where('product.category_id', $category_id)
        ->get(); // Thêm phương thức get() để lấy tất cả dữ liệu
        $category_name = DB::table('danhmuc')->where('danhmuc_id', $category_id)->pluck('danhmuc_ten')->first();
        return view('pages.category.show_category')->with('category_name',$category_name)->with('danhmuc', $cate_product)->with('brand', $brd_product)->with('category_id', $all);
    }


    public function show_danhmuc_home($danhmuc_id){
     
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); // lấy id category
        $product = DB::table('sanpham')->where('sanpham_trangthai', 1)->where('danhmuc_id', $danhmuc_id)->orderby('sanpham_id', 'desc')->paginate(12);
        $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        $ten_danhmuc = DB::table('danhmuc')->where('danhmuc_id', $danhmuc_id)->pluck('danhmuc_ten')->first();
        return view('pages.category.show_category')->with('ten_page', $ten_danhmuc)->with('danhmuc', $cate_product)->with('sanpham', $product)->with('hang', $brand)->with('phanloai', $phanloai);
   
    }

    // public function show_danhmuc_loc(Request $request){
     
    //     $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get(); // lấy id category
    //     $product = DB::table('sanpham')->where('sanpham_trangthai', 1)->where('danhmuc_id', $danhmuc_id)->orderby('sanpham_id', 'desc')->paginate(12);
    //     $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
    //     $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
    //     $ten_page = DB::table('danhmuc')->where('danhmuc_id', $danhmuc_id)->pluck('danhmuc_ten')->first();
    //     return view('pages.category.show_category')->with('ten_page', $ten_page)->with('danhmuc', $cate_product)->with('sanpham', $product)->with('hang', $brand)->with('phanloai', $phanloai);
   
    // }

    public function show_phanloai_loc($phanloai_id){
        // Lấy danh mục sản phẩm
        $cate_product = DB::table('danhmuc')->where('danhmuc_trangthai', 1)->orderby('danhmuc_id', 'desc')->get();
        
        // Lấy phân loại sản phẩm theo ID
        $pl_sp = DB::table('phanloaisp')->where('phanloai_id', $phanloai_id)->first();
        
        // Lấy sản phẩm và join với bảng danh mục và phân loại sản phẩm
        $product = DB::table('sanpham')
            ->join('danhmuc', 'danhmuc.danhmuc_id', '=', 'sanpham.danhmuc_id')
            ->join('phanloaisp', 'phanloaisp.phanloai_id', '=', 'danhmuc.phanloai_id')
            ->where('phanloaisp.phanloai_id', $phanloai_id)
            ->orderby('sanpham_id', 'desc')
            ->paginate(12);
        
        // Lấy danh sách thương hiệu và phân loại sản phẩm
        $brand = DB::table('hangsanpham')->where('hang_trangthai', 1)->orderby('hang_id', 'desc')->get();
        $phanloai = DB::table('phanloaisp')->orderby('phanloai_id', 'asc')->get();
        $ten_page = DB::table('phanloaisp')->where('phanloai_id', $phanloai_id)->pluck('phanloai_ten')->first();


        // Trả về view với dữ liệu đã lấy được
        return view('pages.category.show_category')
            ->with('danhmuc', $cate_product)
            ->with('sanpham', $product)
            ->with('hang', $brand)
            ->with('phanloai', $phanloai)
            ->with('ten_page', $ten_page);
    }
    
    // public function hienthi_danhmuc(){
    //     $cate_product = DB::table('danhmuc')->orderby('danhmuc_id', 'desc')->get();
    //     return view('layout')->with('danhmuc', $cate_product);
    // }
}
