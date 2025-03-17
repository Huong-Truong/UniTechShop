<?php 
return [
    'vnp_TmnCode' => env('VNP_TMN_CODE'),
    'vnp_HashSecret' => env('VNP_HASH_SECRET'),
    'vnp_Url' => env('VNP_URL'),
    'vnp_ReturnUrl' => env('VNP_RETURN_URL', 'http://127.0.0.1:8000/vnpay_return'),
];

?>