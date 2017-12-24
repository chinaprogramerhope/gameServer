<?php
/**
 * Author: hanxiaolong
 * Date: 2017/12/23
 * Time: 15:40
 */
require_once 'autoLoad.php';

class logFile {
    const LOG_FILE_DIR = 'd:\testLog\\';

    const LOG_TYPE_ERROR = 0;
    const LOG_TYPE_INFO = 1;
    const LOG_TYPE_DEBUG = 2;

    const LOG_TYPE = array(
        self::LOG_TYPE_ERROR => 'error',
        self::LOG_TYPE_INFO => 'info',
        self::LOG_TYPE_DEBUG => 'debug'
    );

    public static function log($content, $logType = self::LOG_TYPE_INFO) {
        $filePath = logFile::LOG_FILE_DIR . common::getServerId() . '/log/';
//        if(strpos(PHP_OS, 'win')) {
//            $filePath = 'd:\testLog\\';
//        }
        if(!file_exists($filePath)) {
            mkdir($filePath, 0777, true); //todo 权限
        }

        if(!array_key_exists($logType, logFile::LOG_TYPE)) {
            //todo 错误处理
            return;
        }

        $date = date('Y-m-d');
        $time = date('H:i:s');
        $fileName = $filePath . logFile::LOG_TYPE[$logType] . '-' . $date . '.log';

        $res = fopen($fileName, 'a+');
        if($res === false) {
            //todo 错误处理
            return;
        }

        $content = $time . ' - ' . $content . "\n";
        fwrite($res, $content);
        fclose($res);
    }
}

