<?php
/**
 * Created by PhpStorm.
 * User: hjl
 * Date: 18-10-15
 * Time: 上午2:29
 */

error_reporting(E_ALL);
set_time_limit(0);
date_default_timezone_set('Asia/shanghai');

class websocket {
    const LOG_PATH = '/tmp/';
    const LISTEN_SOCKET_NUM = 9;

    private $sockets = [];
    private $master;

    public function __construct($host, $port) {
        try {
            $this->master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            socket_set_option($this->master, SOL_SOCKET, SO_REUSEADDR, 1);
            socket_bind($this->master, $host, $port);
            socket_listen($this->master, self::LISTEN_SOCKET_NUM);
        } catch (Exception $e) {
            $err_code = socket_last_error();
            $err_msg = socket_strerror($err_code);

            $this->error([
                'error_init_server',
                $err_code,
                $err_msg
            ]);
        }

        $this->sockets[0] = ['resource' => $this->master];
        $pid = posix_getpid();
        $this->debug(["server: {$this->master} started, pid: {$pid}"]);
    }

    private function doServer() {
        $write = $except = null;
        $sockets = array_column($this->sockets, 'resource');
        $read_num = socket_select($sockets, $write, $except, null);
        if (false === $read_num) {
            $this->error([
                'error_select',
                $err_code = socket_last_error(),
                socket_strerror($err_code),
            ]);
            return;
        }

        foreach ($sockets as $socket) {
            if ($socket == $this->master) {
                $client = socket_accept($this->master);
                if (false === $client) {
                    $this->error([
                        'err_accept',
                        $err_code = socket_last_error(),
                        socket_strerror($err_code),
                    ]);
                    continue;
                } else {
                    self::connect($client);
                    continue;
                }
            } else {
                $bytes = @socket_recv($socket, $buffer, 2048, 0);
                if ($bytes < 9) {
                    $recv_msg = $this->disconnect($socket);
                } else {
                    if (!$this->sockets[(int)$socket]['handshake']) {
                        self::handShake($socket, $buffer);
                        continue;
                    } else {
                        $recv_msg = self::parse($buffer);
                    }
                }
                array_unshift($recv_msg, 'receive_msg');
                $msg = self::dealMsg($socket, $recv_msg);

                $this->broadcast($msg);
            }
        }
    }

    public function connect($socket) {
        socket_getpeername($socket, $ip, $port);
        $socket_info = [
            'resource' => $socket,
            'uname' => '',
            'handshake' => false,
            'ip' => $ip,
            'port' => $port,
        ];
        $this->sockets[(int)$socket] = $socket_info;
        $this->debug(array_merge(['socket_connect'], $socket_info));
    }

    public function disconnect($socket) {
        $recv_msg = [
            'type' => 'logout',
            'content' => $this->sockets[(int)$socket]['uname'],
        ];
        unset($this->sockets[(int)$socket]);

        return $recv_msg;
    }

    public function handShake($socket, $buffer) {
        $line_with_key = substr($buffer, strpos($buffer, 'Sec-WebSocket-Key:') + 18);
        $key = trim(substr($line_with_key, 0, strpos($line_with_key, "\r\n")));

        // 生成升级密匙,并拼接websocket升级头
        $upgrade_key = base64_encode(sha1($key . "258EAFA5-E914-47DA-95CA-C5AB0DC85B11", true));// 升级key的算法
        $upgrade_message = "HTTP/1.1 101 Switching Protocols\r\n";
        $upgrade_message .= "Upgrade: websocket\r\n";
        $upgrade_message .= "Sec-WebSocket-Version: 13\r\n";
        $upgrade_message .= "Connection: Upgrade\r\n";
        $upgrade_message .= "Sec-WebSocket-Accept:" . $upgrade_key . "\r\n\r\n";

        socket_write($socket, $upgrade_message, strlen($upgrade_message));
        $this->sockets[(int)$socket]['handshake'] = true;

        socket_getpeername($socket, $ip, $port);
        $this->debug([
            'hand_shake',
            $socket,
            $ip,
            $port
        ]);

        $msg = [
            'type' => 'handshake',
            'content' => 'done'
        ];
        $msg = $this->build(json_encode($msg));
        socket_write($socket, $msg, strlen($msg));

        return true;
    }

    private function broadcast($data) {
        foreach ($this->sockets as $socket) {
            if ($socket['resource'] == $this->master) {
                continue;
            }
            socket_write($socket['resource'], $data, strlen($data));
        }
    }
}