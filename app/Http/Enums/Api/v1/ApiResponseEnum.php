<?php

namespace App\Http\Enums\Api\v1;
//api返回枚举
class ApiResponseEnum
{

    const DEFECT_SIGN = '缺失sign签名|10001';

    const DEFECT_TIMESTAMP = '缺失ts时间戳|10002';

    const DEFECT_NONCE = '缺失nonce|10003';

    const INVALID_SIGN = '非法sign签名|20001';

    const INVALID_TIMESTAMP = '非法ts时间戳|20002';

    const INVALID_NONCE = '非法请求|20003';

    const DEFECT_TOKEN = '缺失token|30001';

    const INVALID_TOKEN = '非法token|30002';

    const TWICE_PASSWORD_NOT_SAME = '两次密码不一致|40001';

    const ACCOUNT_HAS_REGISTER = '账号已注册|40002';

    const INVALID_EMAIL_FORMAT = '邮箱格式不对|40003';

    const INVALID_PASSWORD_LENGTH = '密码至少8位|40004';

    const WEI_CODE_HAS_REGISTER = '微聊号已注册|40005';

    const REGISTER_ERROR = '注册失败|40006';

    const ACCOUNT_NOT_EXISTS = '账号不存在|40007';

    const ACCOUNT_HAS_BAN = '账号已被封禁|40008';

    const INVALID_PASSWORD = '密码错误|40009';

}
