<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TonKho extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'tonkho_soluong'
    ];

    protected $primaryKey = ['sanpham_id', 'kho_id'];
    protected $table = 'tonkho';
}
