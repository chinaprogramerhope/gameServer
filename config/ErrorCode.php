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
    const ERR_ACCOUNT_EXIST = 103; // 账号已存在
    const ERR_ACCOUNT_NOT_EXIST = 104; // 账号不存在
    const ERR_ACCOUNT_PASSWORD_WRONG = 105; // 密码错误

    // 角色
    const ERR_ROLE_CREATE_FAIL = 200; // 创建角色失败
    const ERR_ROLE_ALREADY_EXIST = 201; // 该账号在该服务已有角色
    const ERR_ROLE_NAME_EXIST = 202; // 角色名已存在
    const ERR_ROLE_GET_FAIL = 203; // 获取角色信息失败
    const ERR_ROLE_ADD_EXP_FAIL = 204; // 增加角色经验失败

}