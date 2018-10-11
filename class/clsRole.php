<?php
/**
 * Created by PhpStorm.
 * User: hjl
 * Date: 18-10-10
 * Time: 上午3:01
 */

class clsRole {
    // 创建角色
    public static function create($accountId, $roleName) {
        // 账号是否存在
        $redis = clsRedis::getInstance();
        if (!$redis) {
            Log::error(__METHOD__ . ', ' . __LINE__ . ', init redis fail');
            return conErrorCode::ERR_ROLE_CREATE_FAIL;
        }
        if (!$redis->exists(conRedisKey::auth_register_aid . $accountId)) {
            Log::error(__METHOD__ . ', ' . __LINE__ . ', account not exist, accountId = ' . $accountId);
            return conErrorCode::ERR_ACCOUNT_NOT_EXIST;
        }

        // 角色名合法性检测 todo

        // 角色名长度检测
        if (strlen($roleName) > 10) {
            Log::error(__METHOD__ . ', ' . __LINE__ . ', roleName too long, roleName = ' . $roleName);
            return conErrorCode::ERR_ROLE_NAME_TOO_LONG;
        }

        // 角色名是否重复

        // 该账号在该服是否已有角色


    }

    // 获取角色信息
    public static function get($roleId) {

    }

    // 增加角色经验
    public static function addExp($roleId, $ExpAdd) {

    }
}