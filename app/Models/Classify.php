<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classify extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'phanloai_ten'
    ];
    protected $primaryKey = 'phanloai_id';
    protected $table = 'phanloaisp';

    public function category(){
        return $this->hasMany('App\Category','phanloai_id');
    }
}
