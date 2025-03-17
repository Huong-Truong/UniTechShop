<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    //
    protected $fillable = [
        'sanpham_id','khachhang_id','dg_noidung','dg_xephang','dg_ngay'
    ];
    protected $primaryKey = 'dg_id';
    protected $table = 'danhgia';
   
}
