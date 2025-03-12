<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'khachhang_ten', 'khachhang_email','khachhang_sdt','khachhang_matkhau','khachhang_diachi'
    ];
    protected $primaryKey = 'khachhang_id';
    protected $table = 'khachhang';
}
