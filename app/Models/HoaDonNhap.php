<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoaDonNhap extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
      'hdn_ngay','hdn_tongtien'
    ];
    protected $primaryKey = 'hdn_id';
    protected $table = 'hoadonnhap';
}
