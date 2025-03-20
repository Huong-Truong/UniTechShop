<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongTinKhuyenMai extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'ngaybatdau', 'ngayketthuc','sanpham_id'
    ];

    protected $primaryKey = ['km_id'];
    protected $table = 'thongtinkhuyenmai';
}
