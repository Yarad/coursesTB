<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.11.2017
 * Time: 23:42
 */
define('ROOT_PATH', 'D:/Projects/WEB/_diploma/coursesTB/');

include_once ROOT_PATH . "php_classes/logic/Day.php";
include_once ROOT_PATH . "php_classes/logic/TimeInterval.php";
include_once ROOT_PATH . "php_classes/logic/TimePoint.php";

testInside();

function testInside()
{
    $currDay = new Day(1);
    $currDay->addInterval(new TimeInterval(new TimePoint(0, 1), new TimePoint(23, 56), 1)); //inner
    $currDay->addInterval(new TimeInterval(new TimePoint(0, 1), new TimePoint(23, 56), 2)); //inner
    echo $currDay;
}