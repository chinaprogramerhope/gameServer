<?php
/**
 * Created by PhpStorm.
 * User: hjl
 * Date: 18-10-7
 * Time: 下午4:27
 */
require '../class/Test.php';

$a = [
    'svc' => 'Test',
    'func' => 'test1',
    'param' => 'ok11'
];

echo 1 . "\n";
(new $a['svc']())->{$a['func']}($a['param']);
echo 2 . "\n";