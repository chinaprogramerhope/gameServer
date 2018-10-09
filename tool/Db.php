<?php
/**
 * Created by PhpStorm.
 * User: hjl
 * Date: 18-10-8
 * Time: 下午5:46
 *
 * mysql
 */

class Db {

    /**
     * 连接mysql
     * @return bool|PDO
     */
    public static function init() {
        $dsn = 'mysql:dbname=hxl_game;host=127.0.0.1';
        $user = 'root';
        $password = 'toor';

        try {
            $pdo = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            Log::error(__METHOD__ . ', ' . __LINE__ . ', create pdo fail: ' . $e->getMessage());
            return false;
        }

        return $pdo;
    }
}