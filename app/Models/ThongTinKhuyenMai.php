<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongTinKhuyenMai extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'ngaybatdau', 'ngayketthuc'
    ];

    protected $primaryKey = ['sanpham_id', 'km_id'];
    protected $table = 'thongtinkhuyenmai';
}
