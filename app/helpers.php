<?php

//公共函数

if (!function_exists('make_sign')) {
    //生成签名
    function make_sign($params)
    {
        unset($params['sign']);
        $params['api_key'] = config('api.v1.api_key');//拼接api加密密钥
        ksort($params);//key升序
        $string_temp = http_build_query($params);
        return md5($string_temp);
    }
}

if (!function_exists('encrypt_token')) {
    //生成token
    function encrypt_token($uid)
    {
        $user_info = [
            'uid' => $uid,
            'ts' => time()
        ];
        $user_key = config('api.v1.user_key');
        return openssl_encrypt(base64_encode(json_encode($user_info)), 'DES-ECB', $user_key, 0);
    }
}

if (!function_exists('make_avatar')) {
    function make_avatar($email)
    {
        $md5_email = md5($email);
        return "https://api.multiavatar.com/{$md5_email}.png";
    }
}
