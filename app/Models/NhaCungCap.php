<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'nhacungcap_ten','nhacungcap_diachi','nhacungcap_sdt','nhacungcap_email'
    ];
    protected $primaryKey = 'nhacungcap_id';
    protected $table = 'nhacungcap';

    public function hoadonnhap(){
        return $this->hasMany('App\HoaDonNhap','nhacungcap_id');
    }
}
