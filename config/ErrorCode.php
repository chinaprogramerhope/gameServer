<?php
/**
 * Created by PhpStorm.
 * User: hjl
 * Date: 18-10-7
 * Time: 下午4:36
 */
class ErrorCode {
    const ERR_OK = 0; // 接口请求成功
    const ERR_SERVER = 1; // 服务端错误
    const ERR_CLIENT = 2; // 客户端错误

    const ERR_INVALID_PARAM = 3; // 参数错误

    // 账号
    const ERR_ACCOUNT_LONG = 100; // 账号不能超过10个字符
    const ERR_PASSWORD_LONG = 101; // 密码不能超过10个字符
    const ERR_REGISTER_FAIL = 102; // 服务器错误, 账号注册失败
    const ERR_USER_EXIST = 103; // 账号已存在
    const ERR_USER_NOT_EXIST = 104; // 账号不存在
    const ERR_USER_PASSWORD_WRONG = 105; // 密码错误

}