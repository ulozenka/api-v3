<?php

namespace UlozenkaLib\APIv3\Model\Tracking\TransportService;

use UlozenkaLib\APIv3\Model\Tracking\TransportService\DestinationBranch\Gps;

/**
 * Class Consignment
 * @package UlozenkaLib\APIv3\Model\Tracking
 */
class DestinationBranch
{

    /** @var Link[] */
    protected $links;

    /** @var int */
    protected $id;

    /** @var  string */
    protected $name;

    /** @var  string */
    protected $street;

    /** @var  string */
    protected $town;

    /** @var  string */
    protected $zip;

    /** @var  string ISO 3166-1 alpha-3 code */
    protected $country;

    /** @var Gps */
    protected $gps;

    /** @var  string */
    protected $announcement;

    /**
     * TransportService constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Link[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param Link[] $links
     * @return DestinationBranch
     */
    public function setLinks($links)
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     * @return DestinationBranch
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param string $town
     * @return DestinationBranch
     */
    public function setTown($town)
    {
        $this->town = $town;
        return $this;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     * @return DestinationBranch
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return DestinationBranch
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return Gps
     */
    public function getGps()
    {
        return $this->gps;
    }

    /**
     * @param Gps $gps
     * @return DestinationBranch
     */
    public function setGps($gps)
    {
        $this->gps = $gps;
        return $this;
    }

    /**
     * @return string
     */
    public function getAnnouncement()
    {
        return $this->announcement;
    }

    /**
     * @param string $announcement
     * @return DestinationBranch
     */
    public function setAnnouncement($announcement)
    {
        $this->announcement = $announcement;
        return $this;
    }
}
