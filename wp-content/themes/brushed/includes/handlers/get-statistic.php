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
//$stat->setStat($_POST);
if (isset($_POST['action']) && $_POST['action'] == 'scored_goals')
{
    $goals = $stat->getScoredStat($_POST);
    echo $goals;
}
if (isset($_POST['action']) && ($_POST['action'] == 'scored_goals' || $_POST['action'] == 'missed_goals'))
{
    $goals = $stat->getScoredStat($_POST);
    echo $goals;
}
if (isset($_POST['action']) && ($_POST['action'] == 'wins'))
{
    $goals = $stat->getWinsStat($_POST);
    echo $goals;
}

