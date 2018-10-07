<?php
/**
 * Created by PhpStorm.
 * User: hjl
 * Date: 18-10-7
 * Time: 下午3:45
 */
spl_autoload_register(function ($className) {
    $dirName = [
        '',
        'class',
        'config',
        'coop',
        'log',
        'service',
    ];

    foreach ($dirName as $v) {
        if (empty($v)) {
            $fileName = __DIR__ . '/' . $className . '.php';
        } else {
            $fileName = __DIR__ . '/' . $v . '/' . $className . '.php';
        }

        if (file_exists($fileName)) {
            require $fileName; // 计划
            break;
        }
    }
});