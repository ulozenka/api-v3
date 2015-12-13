<?php

namespace UlozenkaLib\APIv3\Model\Consignment;

/**
 * Class Address
 * @package UlozenkaLib\APIv3\Model\Consignment
 */
class Address
{

    /** @var string */
    private $street;

    /** @var string */
    private $streetNumber;

    /** @var string */
    private $streetNumber2;

    /** @var string */
    private $town;

    /** @var string */
    private $zip;

    /**
     *
     * @param string $street
     * @param string $town
     * @param string $zip
     * @param string $country ISO 3166-1 Alpha3 code
     * @param string $streetNumber
     * @param string $streetNumber2
     */
    public function __construct($street, $town, $zip, $streetNumber = null, $streetNumber2 = null)
    {
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->streetNumber2 = $streetNumber2;
        $this->town = $town;
        $this->zip = $zip;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getStreetWithNumber()
    {
        $streetNumberString = '';
        if (!empty($this->streetNumber)) {
            $streetNumberString .= ' ' . $this->streetNumber;
            if (!empty($this->streetNumber2)) {
                $streetNumberString .= '/' . $this->streetNumber2;
            }
        } else {
            if (!empty($this->streetNumber2)) {
                $streetNumberString .= ' ' . $this->streetNumber2;
            }
        }
        return $this->street . $streetNumberString;
    }

    /**
     * @return string
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * @return string
     */
    public function getStreetNumber2()
    {
        return $this->streetNumber2;
    }

    /**
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     *
     * @param string $street
     * @return \UlozenkaLib\APIv3\Model\Consignment\Address
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     *
     * @param string $streetNumber
     * @return \UlozenkaLib\APIv3\Model\Consignment\Address
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;
        return $this;
    }

    /**
     *
     * @param string $streetNumber2
     * @return \UlozenkaLib\APIv3\Model\Consignment\Address
     */
    public function setStreetNumber2($streetNumber2)
    {
        $this->streetNumber2 = $streetNumber2;
        return $this;
    }

    /**
     *
     * @param string $town
     * @return \UlozenkaLib\APIv3\Model\Consignment\Address
     */
    public function setTown($town)
    {
        $this->town = $town;
        return $this;
    }

    /**
     *
     * @param string $zip
     * @return \UlozenkaLib\APIv3\Model\Consignment\Address
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }
}
