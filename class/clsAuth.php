<?php
/**
 * Created by PhpStorm.
 * User: hjl
 * Date: 18-10-8
 * Time: 下午5:40
 */

class clsAuth {

    /**
     * 注册
     * @param $account
     * @param $password
     * @return array|int
     */
    public static function register($account, $password) {
        // 检测account是否已被注册
        $redis = clsRedis::init();
        if (!$redis) {
            Log::error(__METHOD__ . ', ' . __LINE__ . ', redis init fail');
            return ErrorCode::ERR_REGISTER_FAIL;
        }
        if ($redis->exists(conRedisKey::auth_register . $account)) {
            Log::info(__METHOD__ . ', ' . __LINE__ . ', this account already registered, account = ' . $account);
            return ErrorCode::ERR_ACCOUNT_EXIST;
        }


        // 插入mysql
        $pdo = Db::init();
        if (!$pdo) {
            Log::error(__METHOD__ . ', ' . __LINE__ . ', db init fail');
            return ErrorCode::ERR_REGISTER_FAIL;
        }
        $sql = 'insert into auth(account, password) values (:account, :password)';
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':account' => $account,
                ':password' => $password
            ]);
            $aid = $pdo->lastInsertId();
        } catch (PDOException $e) {
            Log::error(__METHOD__ . ', ' . __LINE__ . ', db error: ' . $e->getMessage());
            return ErrorCode::ERR_REGISTER_FAIL;
        }

        // 插入redis
        $redis->set(conRedisKey::auth_register . $account, $password);

        return [
            'errCode' => ErrorCode::ERR_OK,
            'data' => $aid
        ];
    }

    /**
     * 登陆
     * @param $account
     * @param $password
     * @return int
     */
    public static function login($account, $password) {
        $redis = clsRedis::init();
        if (!$redis) {
            Log::error(__METHOD__ . ', ' . __LINE__ . ', redis init fail');
            return ErrorCode::ERR_REGISTER_FAIL;
        }
        $savedPass = $redis->get(conRedisKey::auth_register . $account);
        if (!$savedPass) {
            Log::warn(__METHOD__ . ', ' . __LINE__ . ', account not exist, account = ' . $account
                . ', password = ' . $password);
            return ErrorCode::ERR_ACCOUNT_NOT_EXIST;
        }
        if ($password !== $savedPass) {
            Log::warn(__METHOD__ . ', ' . __LINE__ . ', password wrong, account = ' . $account
                . ', password = ' . $password);
            return ErrorCode::ERR_ACCOUNT_PASSWORD_WRONG;
        }

        return ErrorCode::ERR_OK;
    }
}