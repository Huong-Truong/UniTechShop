<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HinhAnh extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'hinhanh_ten', 'sanpham_id'
    ];
    protected $primaryKey = 'hinhanh_id';
    protected $table = 'hinhanh';
}
