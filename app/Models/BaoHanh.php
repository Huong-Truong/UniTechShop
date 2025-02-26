<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaoHanh extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'baohanh_thoigian','baohanh_mota'
    ];
    protected $primaryKey = 'baohanh_id';
    protected $table = 'baohanh';

     public function products(){
         return $this->hasMany('App\Product','baohanh_id');
     }
}
