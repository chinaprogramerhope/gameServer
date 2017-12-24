<?php
/**
 * Author: hanxiaolong
 * Date: 2017/12/23
 * Time: 15:53
 */
spl_autoload_register(
    function ($className) {
        require_once $className . '.php';
    }
);