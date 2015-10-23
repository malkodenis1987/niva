<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elvis
 * Date: 20.10.13
 * Time: 18:14
 * To change this template use File | Settings | File Templates.
 */
    session_start();
    require_once('../../../../../wp-load.php');
    require_once('../classes/user.class.php');

    $user = new User();
    $forgot = $user->forgotPassword($_POST['email']);
    if ($user->errors)
    {
        $errorCodes = array_keys($user->errors);
        foreach ($errorCodes as $errorCode)
        {
            echo '<p>'.$formErrors[$errorCode].'</p>';
        }
    }
    else
    {
        echo 'success';
    }