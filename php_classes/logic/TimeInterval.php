<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.11.2017
 * Time: 15:43
 */
class TimeInterval
{
    private $beginTime; //содержит информацию о времени
    private $endTime;   //завимимого только ч.м.
    private $priority = 0; //0-infinity
    private $isExist;

    public function __construct(DateTime $beginTime, DateTime $endTime, $priority)
    {
        $this->setIntervalBounds($beginTime, $endTime);
        $this->setPriority($priority);
    }

    public function setIntervalBounds(DateTime $beginTime, DateTime $endTime)
    {
        $this->changeEndTime($endTime);
        $this->changeBeginTime($beginTime);
    }

    //устанавливает время начала промежутка с проверкой начало < конец
    //возвращает false и устанавливает в false isExist, если время начала и конца в итоге совпадают
    public function changeBeginTime(DateTime $beginTime)
    {
        if (!($beginTime instanceof DateTime))
            return false;
        else {
            if ($beginTime < $this->getEndTime()) {
                $this->beginTime = $beginTime;
                $this->isExist = true;
                return true;
            } else {
                $this->isExist = false;
                $this->beginTime = $this->getEndTime();
                return false;
            }
        }
    }

    //устанавливает время начала промежутка с проверкой конец > начало
    //возвращает false и устанавливает в false isExist, если время начала и конца в итоге совпадают
    public function changeEndTime(DateTime $endTime)
    {
        if (!($endTime instanceof DateTime))
            return false;
        else {
            if ($endTime > $this->getBeginTime()) {
                $this->endTime = $endTime;
                $this->isExist = true;
                return true;
            } else {
                $this->endTime = $this->getBeginTime();
                $this->isExist = false;
                return false;
            }
        }
    }

    public function setPriority(int $priority)
    {
        if (!is_int($priority) || $priority < 0)
            return false;
        else {
            $this->priority = $priority;
            return true;
        }
    }

    public function getBeginTime()
    {
        return $this->beginTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function getPriority()
    {
        return $this->priority;
    }
}