<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class HandleError
{
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (\Exception $e) {
            // Ghi log lỗi
            Log::error('Lỗi xảy ra: ' . $e->getMessage());

            // Hiện thông báo lỗi
            return response()->json(['error' => 'Đã xảy ra lỗi. Vui lòng thử lại sau.'], 500);
        }
    }
}
