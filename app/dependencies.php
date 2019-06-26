<?php

$container = $app->getContainer();

$container['db'] = function ($c) {
    $config = $c['settings']['db'];

    $db = new \MysqliDb(array(
        'host' => $config['host'],
        'username' => $config['user'],
        'password' => $config['pass'],
        'db' => $config['dbname'],
        'port' => $config['port'],
        'charset' => $config['charset'],
    ));

    return $db;
};
