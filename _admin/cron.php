<?php
require __DIR__ . '/../vendor/autoload.php';
require_once (__DIR__ . '/../classes/db.class.php');
require_once (__DIR__ . '/../includes/global_funcs.php');

$type = isset($argv[1]) ? $argv[1] : 'hourly';

$db = new DBConnection();

switch ($type) {
    case 'daily':
        $stockModel = new App\Model\Stocks($db);
        $stockModel->updateStockValues('daily');
        break;
    case 'hourly':
        $stockModel = new App\Model\Stocks($db);
        $stockModel->updateStockValues('hourly');
    default:
        break;
}