<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'sanpham_ten', 'sanpham_gia','sanpham_hinhanh','sanpham_mota','sanpham_trangthai', 'sanpham_thongso', 'sanpham_xuatxu'
    ];

    protected $primaryKey = 'sanpham_id';
    protected $table = 'sanpham';

    public function hdsd(){
        return $this->hasMany('App\HDSD','sanpham_id');
    }

    public function hinhanh(){
        return $this->hasMany('App\HinhAnh','sanpham_id');
    }

    public function thongtinkm(){
        return $this->hasMany('App\ThongtinKhuyenMai','sanpham_id');
    }

    public function giadv(){
        return $this->hasMany('App\PriceService','sanpham_id');
    }

    public function tonkho(){
        return $this->hasMany('App\TonKho','sanpham_id');
        
    }





}
