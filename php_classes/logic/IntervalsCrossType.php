<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.11.2017
 * Time: 15:29
 */
class IntervalsCrossType
{
    public static $noCross = 0; //промежутки не перескаются
    public static $beginInsideCross = 1; //внутри первого промежутка находится начало второго
    public static $insideCross = 2; //внутри первого промежутка находится второй
    public static $endInsideCross = 3; //внутри первого промежутка находится конец второго
    public static $outsideCross = 4; //первый промежуток внутри второго
}