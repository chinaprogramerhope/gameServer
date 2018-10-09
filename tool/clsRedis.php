<?php
/**
 * Created by PhpStorm.
 * User: hjl
 * Date: 18-10-9
 * Time: 下午4:31
 *
 * redis
 *
 * todo 玩家register信息永久保存是否合适
 */

class clsRedis {

    /**
     * 连接redis  todo 一个服一个redisdb
     * @return bool|Redis
     */
    public static function init() {
        try {
            $redis = new Redis();
            $redis->connect('127.0.0.1', 6379);
        } catch (Exception $e) {
            Log::error(__METHOD__ . ', ' . __LINE__ .', init redis fail: ' . $e->getMessage());
            return false;
        }

        return $redis;
    }
}