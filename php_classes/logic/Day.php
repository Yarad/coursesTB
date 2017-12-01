<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.11.2017
 * Time: 15:49
 */
include_once ROOT_PATH . '/php_classes/logic/IntervalsCrossType.php';

class Day
{
    private $intervals;

    /*В dateInfo будет хранится "время" этого дня в формате DateTime.
    Значащими будут только его номер в этом месяце, день недели и т.п.*/
    private $dayNum;

    public function __construct(int $dayNum)
    {
        $this->dayNum = $dayNum;
        $this->intervals = new SplDoublyLinkedList();
    }

    public function addInterval(TimeInterval $intervalToAdd)
    {
        if ($this->intervals->isEmpty()) //всегда считается заполненным промежутками
        {
            $this->intervals->push(new TimeInterval(new TimePoint(0, 0), new TimePoint(23, 59), 0));
        }
        $this->intervals->rewind();

        while ($this->intervals->current() != null) {
            $current = $this->intervals->current();
            $crossType = $this->getIntervalsCrossType($intervalToAdd, $current);

            //вроде бы протещено
            if ($crossType == IntervalsCrossType::$insideCross) {
                if($current->getPriority() != $intervalToAdd->getPriority()) {
                    $oldEnd = $current->getEndTime();
                    $current->changeEndTime($intervalToAdd->getBeginTime());
                    $this->intervals->add($this->intervals->key() + 1, $intervalToAdd);
                    $this->intervals->add($this->intervals->key() + 2, new TimeInterval($intervalToAdd->getEndTime(), $oldEnd, $current->getPriority()));
                }
                break;
            }

            //протестить
            if ($crossType == IntervalsCrossType::$beginInsideCross) {
                $current->changeEndTime($intervalToAdd->getBeginTime());
                $keyToPlace = $this->intervals->key() + 1;

                //подчищаем либо до конца, либо до промежутка, на который приходится конец
                $this->intervals->next();
                while ($this->intervals->current() != null && $this->getIntervalsCrossType($intervalToAdd, $this->intervals->current()) != IntervalsCrossType::$endInsideCross)
                    $this->intervals->offsetUnset($this->intervals->key());

                if ($this->intervals->current() != null) {
                    $this->intervals->current()->changeBeginTime($intervalToAdd->getEndTime());
                }
                /*
                                do {
                                    $this->intervals->next();
                                    $nextCrossType = $this->getIntervalsCrossType($intervalToAdd,$this->intervals->current());
                                    if($nextCrossType != IntervalsCrossType::$endInsideCross)
                                    {
                                        $this->intervals->offsetUnset($this->intervals->key());
                                    }
                                }
                                while($this->intervals->current() != null && $nextCrossType != IntervalsCrossType::$endInsideCross);
                */
                $this->intervals->add($keyToPlace, $intervalToAdd);
            }
            $this->intervals->next();
        }
        $this->clearUnexistent();
        return true;
    }

    public function __toString()
    {
        $retStr = "";

        $this->intervals->rewind();

        while ($this->intervals->current() != null)
        {
            $retStr .= $this->intervals->current() . '<br>' . "\n";
            $this->intervals->next();
        }

        return $retStr;
    }

    private function getIntervalsCrossType(TimeInterval $touchesInterval, TimeInterval $touchedInterval)
    {
        if ($touchesInterval->getBeginTime() < $touchedInterval->getBeginTime() && $touchesInterval->getEndTime() > $touchedInterval->getEndTime())
            return IntervalsCrossType::$outsideCross;

        if ($touchesInterval->getBeginTime() >= $touchedInterval->getBeginTime() && $touchesInterval->getEndTime() <= $touchedInterval->getEndTime())
            return IntervalsCrossType::$insideCross;

        if ($touchesInterval->getBeginTime() >= $touchedInterval->getBeginTime() && $touchesInterval->getBeginTime() < $touchedInterval->getEndTime() && $touchesInterval->getEndTime() > $touchedInterval->getEndTime())
            return IntervalsCrossType::$beginInsideCross;

        if ($touchesInterval->getEndTime() > $touchedInterval->getBeginTime() && $touchesInterval->getEndTime() <= $touchedInterval->getEndTime() && $touchesInterval->getBeginTime() < $touchedInterval->getBeginTime())
            return IntervalsCrossType::$endInsideCross;

        return IntervalsCrossType::$noCross;
    }
    private function clearUnexistent()
    {
        $this->intervals->rewind();

        while ($this->intervals->current() != null) {
            if (!$this->intervals->current()->ifExist())
                $this->intervals->offsetUnset($this->intervals->key());
            else
                $this->intervals->next();
        }
    }
}