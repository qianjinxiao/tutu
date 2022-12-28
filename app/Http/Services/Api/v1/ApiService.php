<?php

namespace App\Http\Services\Api\v1;

use App\Http\Contracts\Api\v1\ApiInterface;
use App\Http\Enums\Api\v1\ApiCacheKeyEnum;
use App\Http\Enums\Api\v1\ApiResponseEnum;
use Illuminate\Support\Facades\Redis;
use Sevming\LaravelResponse\Support\Facades\Response;

class ApiService implements ApiInterface
{
    public static $instance = null;

    /**
     * @return static|null
     * 单例模式
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * @param $params array 入参
     * 签名认证
     */
    public function checkSign($params)
    {
        // TODO: Implement checkSign() method.
        if (!isset($params['sign'])) {
            return Response::fail(ApiResponseEnum::DEFECT_SIGN);
        }
        if (!isset($params['ts'])) {
            return Response::fail(ApiResponseEnum::DEFECT_TIMESTAMP);
        }
        if (!isset($params['nonce'])) {
            return Response::fail(ApiResponseEnum::DEFECT_NONCE);
        }

        $ts = $params['ts'];//时间戳
        $nonce = $params['nonce'];
        $sign = $params['sign'];
        $time = time();
        if ($ts > $time) {
            return Response::fail(ApiResponseEnum::INVALID_TIMESTAMP);
        }

        $redis = Redis::connection();
        if ($redis->exists(ApiCacheKeyEnum::NONCE_CACHE_KEY . $nonce)) {
            return Response::fail(ApiResponseEnum::INVALID_NONCE);
        }
        $api_sign = make_sign($params);
        if ($api_sign !== $sign) {
            return Response::fail(ApiResponseEnum::INVALID_SIGN);
        }

        //5分钟内一个sign不能重复请求，防止重放攻击
        $redis->setex(ApiCacheKeyEnum::NONCE_CACHE_KEY . $nonce, 300, $time);

        return true;
    }

    /**
     * @param $params
     * TOKEN校验
     */
    public function checkToken($params)
    {
        // TODO: Implement checkToken() method.

        $action_list = explode('/', \request()->path());
        $action = end($action_list);
        //带下划线的方法无需登录，直接放行
        if (stripos($action, '_')) {
            return true;
        }

        if (!isset($params['token'])) {
            return Response::fail(ApiResponseEnum::DEFECT_TOKEN);
        }

        $token = $params['token'];

        //查缓存是否存在该登录用户token
        $redis = Redis::connection();

        $cache_token = $redis->get(ApiCacheKeyEnum::TOKEN_CACHE_KEY . $token);

        if (!$cache_token) {
            return Response::fail(ApiResponseEnum::INVALID_TOKEN);
        }

        return true;
    }
}
