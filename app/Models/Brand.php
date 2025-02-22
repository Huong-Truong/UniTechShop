<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'hang_ten', 'hang_trangthai','hang_mota'
    ];
    protected $primaryKey = 'hang_id';
    protected $table = 'hangsanpham';

     public function products(){
         return $this->hasMany('App\Product','hang_id');
     }
}
