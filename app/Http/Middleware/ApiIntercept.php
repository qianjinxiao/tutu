<?php

namespace App\Http\Middleware;

use App\Http\Services\Api\v1\ApiService;
use Closure;

class ApiIntercept
{
    public function handle($request, Closure $next)
    {
        $params = $request->input();
        $env = config('env');
        if ($env !== 'local') {
            //非本地环境，需要签名认证
            ApiService::getInstance()->checkSign($params);
        }

        return $next($request);
    }
}
