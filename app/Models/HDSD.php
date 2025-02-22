<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HDSD extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'hdsd_mota', 'hdsd_video'
    ];
    protected $primaryKey = 'sanpham_id';
    protected $table = 'hdsd';

     public function hdsd(){
         return $this->hasMany('App\HDSD','sanpham_id');
     }
}
