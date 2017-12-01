<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.11.2017
 * Time: 2:24
 */
class TimePoint extends DateTime
{
    public function __construct(int $hour,int $minutes,int $seconds = 0)
    {
        parent::__construct('now', new DateTimeZone('UTC'));
        $this->setTime($hour,$minutes,$seconds);
    }

    public function __toString()
    {
        return $this->format("H:i");
    }
}