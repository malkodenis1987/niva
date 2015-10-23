<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elvis
 * Date: 20.10.13
 * Time: 15:27
 * To change this template use File | Settings | File Templates.
 */
session_start();
require_once('../../../../../wp-load.php');
require_once('../classes/statistic.class.php');

$stat = new Statistic();
$stat->setStat($_POST);
if ($stat->errors)
{
    $errorCodes = array_keys($stat->errors);
    foreach ($errorCodes as $errorCode)
    {
        echo '<p>'.$formErrors[$errorCode].'</p>';
    }
}
else
{
    echo 'success';
}