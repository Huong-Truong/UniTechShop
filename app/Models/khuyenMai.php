<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class khuyenMai extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'km_gia', 'km_donvi','km_mota', 'brand'
    ];

    protected $primaryKey = 'km_id';
    protected $table = 'khuyenmai';

    public function thongtinkm(){
        return $this->hasMany('App\ThongtinKhuyenMai','km_id');
    }

}
