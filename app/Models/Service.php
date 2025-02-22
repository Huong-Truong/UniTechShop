<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'dv_ten'
    ];

    protected $primaryKey = 'dv_id';
    protected $table = 'dichvukemtheo';

    public function giadv(){
        return $this->hasMany('App\PriceService','dv_id');
    }
}
