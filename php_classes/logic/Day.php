<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.11.2017
 * Time: 15:49
 */
class Day
{
    private $intervals;

    /*В dateInfo будет хранится "время" этого дня в формате DateTime.
    Значащими будут только его номер в этом месяце, день недели и т.п.*/
    private $dateInfo;

    public function __construct(DateTime $dateInfo)
    {
        $this->dateInfo = $dateInfo;
        $this->intervals = new SplDoublyLinkedList();
    }

    public function addInterval(TimeInterval $intervalToAdd)
    {
        if($this->intervals->isEmpty()) return false; //всегда считается заполненным промежутками
        $this->intervals->rewind();

        while($this->intervals->current() != null)
        {
            $current = &$this->intervals->current();
            if($intervalToAdd->getBeginTime() < $current->getBeginTime() && $intervalToAdd->getEndTime() > $current->getBeginTime())
            {
                $shouldDelete = !$current->setBeginTime($intervalToAdd->getEndTime());
            }
            $this->intervals->next();
        }
        return true;
    }
}