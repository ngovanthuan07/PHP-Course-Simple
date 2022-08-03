<?php
require_once __DIR__ . '/./vendor/autoload.php';
require_once __DIR__ . '/./utils/ConstantUtil.php';
// import lib
\app\utils\ConstantUtil::autoImportDir([
    'constant',
    'config',
    'core',
    ['utils', ['ConstantUtil.php']],
    'model',
    'controller',
]);
use app\core\Application;

$conditions = [
    [
        'column' => 'id',
        'operator' => '=',
        'value' => 2.5
    ]
];


$where = \app\utils\ConstantUtil::findProperty($conditions);
$sql = "SELECT * FORM users" . $where;
echo '<pre>';
var_dump($sql);
echo '</pre>';
exit;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = new Application();

$app->db->applyMigrations();