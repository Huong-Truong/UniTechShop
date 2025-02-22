<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    
    public $timestamps = false;
    protected $fillable = [
        'danhmuc_ten', 'danhmuc_trangthai','danhmuc_mota'
    ];
    protected $primaryKey = 'danhmuc_id';
    protected $table = 'danhmuc';

     public function products(){
         return $this->hasMany('App\Product','danhmuc_id');
     }
}
