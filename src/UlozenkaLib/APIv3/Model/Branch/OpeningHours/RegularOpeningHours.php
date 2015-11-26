<?php

namespace UlozenkaLib\APIv3\Model\Branch\OpeningHours;

use UlozenkaLib\APIv3\Enum\DayOfTheWeek;
use UlozenkaLib\APIv3\Model\Branch\Hours;

/**
 * Class RegularOpeningHours
 * @package UlozenkaLib\APIv3\Model
 */
class RegularOpeningHours
{

    /** @var Hours[] */
    protected $monday = [];

    /** @var Hours[] */
    protected $tuesday = [];

    /** @var Hours[] */
    protected $wednesday = [];

    /** @var Hours[] */
    protected $thursday = [];

    /** @var Hours[] */
    protected $friday = [];

    /** @var Hours[] */
    protected $saturday = [];

    /** @var Hours[] */
    protected $sunday = [];

    /**
     * Format
     * @return array
     */
    public function getAsArray()
    {
        $openingHours = [
            DayOfTheWeek::MONDAY => $this->getMonday(),
            DayOfTheWeek::TUESDAY => $this->getTuesday(),
            DayOfTheWeek::WEDNESDAY => $this->getWednesday(),
            DayOfTheWeek::THURSDAY => $this->getThursday(),
            DayOfTheWeek::FRIDAY => $this->getFriday(),
            DayOfTheWeek::SATURDAY => $this->getSaturday(),
            DayOfTheWeek::SUNDAY => $this->getSunday(),
        ];
        return $openingHours;
    }

    /**
     *
     * @return Hours[]
     */
    public function getMonday()
    {
        return $this->monday;
    }

    /**
     *
     * @return Hours[]
     */
    public function getTuesday()
    {
        return $this->tuesday;
    }

    /**
     *
     * @return Hours[]
     */
    public function getWednesday()
    {
        return $this->wednesday;
    }

    public function getThursday()
    {
        return $this->thursday;
    }

    /**
     *
     * @return Hours[]
     */
    public function getFriday()
    {
        return $this->friday;
    }

    /**
     *
     * @return Hours[]
     */
    public function getSaturday()
    {
        return $this->saturday;
    }

    /**
     *
     * @return Hours[]
     */
    public function getSunday()
    {
        return $this->sunday;
    }

    /**
     *
     * @param string $dayOfTheWeek
     * @param Hours $hours
     * @return RegularOpeningHours
     */
    public function addHours($dayOfTheWeek, $hours)
    {
        $this->{$dayOfTheWeek}[] = $hours;
        return $this;
    }
}
