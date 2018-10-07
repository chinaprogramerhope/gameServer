<?php
/**
 * Created by PhpStorm.
 * User: hjl
 * Date: 18-10-7
 * Time: 下午3:36
 */

require 'autoload.php';

$ret = [
    'errCode' => ERR_OK,
    'data' => []
];

if (!isset($_POST['svc']) || !isset($_POST['func'])) {
    Log::error(basename(__FILE__) . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($_POST));
    $ret['errCode'] = ERR_FAIL;
    echo json_encode($ret);
    ob_flush();
    exit();
}
$_POST['param'] = isset($_POST['param']) ? $_POST['param'] : $_POST['param'];

$ret = (new $_POST['svc'])->{$_POST['func']}($_POST['param']);

if (!isset($ret['errCode'])) {
    Log::error(basename(__FILE__) . ', ' . __LINE__ . ', server return is wrong, ret = ' . json_encode($ret));
    $ret = [
        'errCode' => ERR_SERVER,
        'data' => []
    ];
    echo json_encode($ret);
    ob_flush();
    exit();
}
if (!isset($ret['data'])) {
    $ret['data'] = [];
}

echo json_encode($ret);
ob_flush();
exit();
