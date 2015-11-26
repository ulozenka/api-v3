<?php

namespace UlozenkaLib\APIv3\Model\Consignment;

/**
 * Class Parcel
 * @package UlozenkaLib\APIv3\Model\Consignment
 */
class Parcel
{

    /** @var string */
    protected $parcelNumber;

    public function __construct($parcelNumber)
    {
        $this->parcelNumber = $parcelNumber;
    }

    /**
     *
     * @return string
     */
    public function getParcelNumber()
    {
        return $this->parcelNumber;
    }

    /**
     *
     * @param string $parcelNumber
     * @return \UlozenkaLib\APIv3\Model\Consignment\Parcel
     */
    public function setParcelNumber($parcelNumber)
    {
        $this->parcelNumber = $parcelNumber;
        return $this;
    }
}
