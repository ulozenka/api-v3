<?php

namespace UlozenkaLib\APIv3\Model\TransportServices\Branches;

use UlozenkaLib\APIv3\Model\Branch\BaseBranch;
use UlozenkaLib\APIv3\Model\Branch\Gps;
use UlozenkaLib\APIv3\Model\Branch\Navigation;
use UlozenkaLib\APIv3\Model\Branch\OpeningHours\OpeningHours;

/**
 * Abstract Class Branch
 * @package UlozenkaLib\APIv3\Model
 */
abstract class Branch extends BaseBranch
{

    /** @var string */
    protected $phone;

    /** @var string */
    protected $email;

    /** @var OpeningHours  */
    protected $openingHours;

    /** @var Gps */
    protected $gps;

    /** @var Navigation */
    protected $navigation;

    /** @var string */
    protected $otherInfo;

    /** @var bool */
    protected $cardPaymentAccepted;

    /**
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @return OpeningHours
     */
    public function getOpeningHours()
    {
        return $this->openingHours;
    }

    /**
     *
     * @return Gps
     */
    public function getGps()
    {
        return $this->gps;
    }

    /**
     *
     * @return Navigation
     */
    public function getNavigation()
    {
        return $this->navigation;
    }

    /**
     *
     * @return string
     */
    public function getOtherInfo()
    {
        return $this->otherInfo;
    }

    /**
     *
     * @return bool
     */
    public function getCardPaymentAccepted()
    {
        return $this->cardPaymentAccepted;
    }

    /**
     *
     * @param string $phone
     * @return \UlozenkaLib\APIv3\Model\TransportServices\Branches\Branch
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     *
     * @param string $email
     * @return \UlozenkaLib\APIv3\Model\TransportServices\Branches\Branch
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     *
     * @param OpeningHours $openingHours
     * @return \UlozenkaLib\APIv3\Model\TransportServices\Branches\Branch
     */
    public function setOpeningHours(OpeningHours $openingHours)
    {
        $this->openingHours = $openingHours;
        return $this;
    }

    /**
     *
     * @param Gps $gps
     * @return \UlozenkaLib\APIv3\Model\TransportServices\Branches\Branch
     */
    public function setGps(Gps $gps)
    {
        $this->gps = $gps;
        return $this;
    }

    /**
     *
     * @param Navigation $navigation
     * @return \UlozenkaLib\APIv3\Model\TransportServices\Branches\Branch
     */
    public function setNavigation(Navigation $navigation)
    {
        $this->navigation = $navigation;
        return $this;
    }

    /**
     *
     * @param string $otherInfo
     * @return \UlozenkaLib\APIv3\Model\TransportServices\Branches\Branch
     */
    public function setOtherInfo($otherInfo)
    {
        $this->otherInfo = $otherInfo;
        return $this;
    }

    /**
     *
     * @param bool|int $cardPaymentAccepted
     * @return \UlozenkaLib\APIv3\Model\TransportServices\Branches\Branch
     */
    public function setCardPaymentAccepted($cardPaymentAccepted)
    {
        $this->cardPaymentAccepted = (bool) $cardPaymentAccepted;
        return $this;
    }
}
