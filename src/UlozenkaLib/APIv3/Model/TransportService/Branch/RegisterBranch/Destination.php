<?php

namespace UlozenkaLib\APIv3\Model\TransportService\Branch\RegisterBranch;

use UlozenkaLib\APIv3\Model\TransportService\Branch\AllowedConsignmentTypes;

/**
 * Class Destination
 * @package UlozenkaLib\APIv3\Model
 */
class Destination
{

    /** @var string ISO 3166-1 Alpha3 */
    protected $country;

    /** @var bool */
    protected $active;

    /** @var bool */
    protected $preparing;

    /** @var AllowedConsignmentTypes */
    protected $allowedConsignmentTypes;

    /**
     *
     * @param string $country ISO 3166-1 Alpha3
     * @param bool|int $active
     * @param bool|int $preparing
     * @param AllowedConsignmentTypes $allowedConsignmentTypes
     */
    public function __construct($country, $active, $preparing, AllowedConsignmentTypes $allowedConsignmentTypes)
    {
        $this->country = $country;
        $this->setActive($active);
        $this->setPreparing($preparing);
        $this->allowedConsignmentTypes = $allowedConsignmentTypes;
    }

    /**
     *
     * @return string ISO 3166-1 Alpha3
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     *
     * @return bool
     */
    public function getPreparing()
    {
        return $this->preparing;
    }

    /**
     *
     * @return AllowedConsignmentTypes
     */
    public function getAllowedConsignmentTypes()
    {
        return $this->allowedConsignmentTypes;
    }

    /**
     *
     * @param string $country ISO 3166-1 Alpha3
     * @return Destination
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     *
     * @param bool|int $active
     * @return Destination
     */
    public function setActive($active)
    {
        $this->active = (bool)$active;
        return $this;
    }

    /**
     *
     * @param bool|int $preparing
     * @return Destination
     */
    public function setPreparing($preparing)
    {
        $this->preparing = (bool)$preparing;
        return $this;
    }

    /**
     *
     * @param AllowedConsignmentTypes $allowedConsignmentTypes
     * @return Destination
     */
    public function setAllowedConsignmentTypes(AllowedConsignmentTypes $allowedConsignmentTypes)
    {
        $this->allowedConsignmentTypes = $allowedConsignmentTypes;
        return $this;
    }
}
