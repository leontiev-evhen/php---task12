<?php
require_once 'config.php';
spl_autoload_register(function ($class_name) {
    require_once 'libs/'.$class_name . '.php';
});

try
{

    /*============ distinct ===================*/
    print_r((new Db())
        ->select(['data'])
        ->from('MY_TEST')
        ->where('key')
        ->valueWhere('user11')
        ->execute());




}
catch (Exception $e)
{
    echo $e->getMessage();
}

require_once 'templates/index.php';

?>
