<?php
require_once 'config.php';
spl_autoload_register(function ($class_name) {
    require_once 'libs/'.$class_name . '.php';
});

try
{
    /*============ select ===================*/

    $params = ['key' => 'user11'];
    $resultMysql = (new MySql())->selectPdo('MY_TEST', $params);
    $resultPostgreSql = (new PostgreSql())->selectPdo('PG_TEST', $params);


    /*============ insert ===================*/

    $params = ['key' => 'user11-2', 'data' => 'cr7'];
    //$resultMysql = (new MySql())->insertPdo('MY_TEST', $params);
    //$resultPostgreSql = (new PostgreSql())->insertPdo('PG_TEST', $params);

    /*============ update ===================*/

    $params = ['key' => 'user11-4', 'data' => 'cr10'];
    $condition = ['key' => 'user11-2'];
    //$resultMysql = (new MySql())->updatePdo('MY_TEST', $params, $condition);
   // $resultPostgreSql = (new PostgreSql())->updatePdo('PG_TEST', $params, $condition);

    /*============ delete ===================*/

    $params = ['key' => 'user11-4'];
    //$resultMysql = (new MySql())->deletePdo('MY_TEST', $params);
    //$resultPostgreSql = (new PostgreSql())->deletePdo('PG_TEST', $params);

}
catch (Exception $e)
{
    echo $e->getMessage();
}

require_once 'templates/index.php';

?>
