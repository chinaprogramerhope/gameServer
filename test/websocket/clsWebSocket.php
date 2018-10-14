<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/10/14
 * Time: 17:17
 */

class clsWebSocket {
    const listen_socket_num = 10;

    public function createSocket($host = '127.0.0.1', $port = '8080') {
        // 创建socket
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        // 设置ip和端口重用, 在重启服务器后能重新使用此端口
        socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
        // 绑定ip和端口
        socket_bind($socket, $host, $port);
        // 监听连接
        socket_listen($socket, self::listen_socket_num);
    }
}

$webSocket = new clsWebSocket();
$webSocket->createSocket();