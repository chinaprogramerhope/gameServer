<?php
/**
 * Created by PhpStorm.
 * User: hjl
 * Date: 18-10-7
 * Time: 下午4:09
 */
class Log {
    // 调试日志
    public static function debug($content) {
        self::writeFile('debug', $content);
    }

    // 运行日志, 打印感兴趣或重要信息, 勿滥用
    public static function info($content) {
        self::writeFile('info', $content);
    }

    // 潜在错误, 不是错误信息, 但有必要提示
    public static function warn($content) {
        self::writeFile('warn', $content);
    }

    // 错误日志, 出现这种错误时, 须要查找原因
    public static function error($content) {
        self::writeFile('error', $content);
    }

//    // 重大错误, 出现这种错误时, 须停止程序
//    public static function fatal($content) {
//        self::writeFile('fatal', $content);
//    }

    private static function writeFile($level, $content) {
        $logDir = '/home/game_server/log/'; // notice: 运行php的用户必须对要写入的目录有写权限 todo
        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $today = date('Y-m-d');
        $timeNow = date('Y-m-d H:i:s');

        $file = $logDir . $today . '_' . $level . '.log';
        $res = fopen($file, 'ab');
        $content = $timeNow . ' : ' . $content . "\n";
        fwrite($res, $content);
        fclose($res);
    }
}