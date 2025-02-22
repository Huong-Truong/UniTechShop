<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceService extends Model
{
    //
    
    public $timestamps = false;
    protected $fillable = [
        'giadichvu','sanpham_id','dv_id'
    ];

    protected $primaryKey = ['sanpham_id', 'dv_id'];
    protected $table = 'giadichvu';
    
    // Tùy chỉnh phương thức find để hỗ trợ khóa chính phức hợp
    public static function findComposite($sanpham_id, $dv_id)
    {
        return self::where('sanpham_id', $sanpham_id)->where('dv_id', $dv_id)->first();
    }
}

