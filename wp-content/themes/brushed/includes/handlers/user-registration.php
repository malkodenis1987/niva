<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elvis
 * Date: 20.10.13
 * Time: 14:52
 * To change this template use File | Settings | File Templates.
 */
    session_start();
    require_once('../../../../../wp-load.php');
    require_once('../classes/user.class.php');

    $user = new User();
    $newUser = $user->createUser($_POST);
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
