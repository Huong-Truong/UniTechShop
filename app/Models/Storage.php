<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'kho_ten','kho_diachi'
    ];

    protected $primaryKey = 'kho_id';
    protected $table = 'khohang';

     public function tonkho(){
         return $this->hasMany('App\TonKho','kho_id');
     }

     public function hoadonnhap(){
        return $this->hasMany('App\HoaDonNhap','kho_id');
    }
}
