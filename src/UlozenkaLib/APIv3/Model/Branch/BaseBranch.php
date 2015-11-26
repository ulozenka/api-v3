<?php

namespace UlozenkaLib\APIv3\Model\Branch;

use UlozenkaLib\APIv3\Enum\Attributes\LinkAttr;
use UlozenkaLib\APIv3\Model\Link;

/**
 * Abstract Class BaseBranch
 * @package UlozenkaLib\APIv3\Model
 */
abstract class BaseBranch
{

    /** @var Link[] */
    protected $links;

    /** @var int */
    protected $id;

    /** @var string */
    protected $shortcut;

    /** @var string */
    protected $name;

    /** @var string */
    protected $street;

    /** @var string */
    protected $houseNumber;

    /** @var string */
    protected $town;

    /** @var string */
    protected $zip;

    /** @var District */
    protected $district;

    /** @var string ISO 3166-1 Alpha3 */
    protected $country;

    /** @var int  0 = base branch, 1 = partner branch */
    protected $partner;

    /**
     *
     * @return Link[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getShortcut()
    {
        return $this->shortcut;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     *
     * @return string|null
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     *
     * @return District
     */
    public function getDistrict()
    {
        return $this->district;
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
     * @return int
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     *
     * @return Link|null
     */
    public function getPictureLink()
    {
        foreach ($this->links as $link) {
            if ($link->getResourceName() === LinkAttr::RESOURCE_PICTURE) {
                return $link;
            }
        }
        return null;
    }

    /**
     *
     * @return Link|null
     */
    public function getWebsiteLink()
    {
        foreach ($this->links as $link) {
            if ($link->getResourceName() === LinkAttr::RESOURCE_WEBSITE) {
                return $link;
            }
        }
        return null;
    }

    /**
     *
     * @param Link[] $links
     * @return BaseBranch
     */
    public function setLinks($links)
    {
        $this->links = $links;
        return $this;
    }

    /**
     *
     * @param int $id
     * @return BaseBranch
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @param string $shortcut
     * @return BaseBranch
     */
    public function setShortcut($shortcut)
    {
        $this->shortcut = $shortcut;
        return $this;
    }

    /**
     *
     * @param string $name
     * @return BaseBranch
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @param string $street
     * @return BaseBranch
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     *
     * @param string $houseNumber
     * @return BaseBranch
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;
        return $this;
    }

    /**
     *
     * @param string $town
     * @return BaseBranch
     */
    public function setTown($town)
    {
        $this->town = $town;
        return $this;
    }

    /**
     *
     * @param string $zip
     * @return BaseBranch
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     *
     * @param District $district
     * @return BaseBranch
     */
    public function setDistrict(District $district)
    {
        $this->district = $district;
        return $this;
    }

    /**
     *
     * @param string $country ISO 3166-1 Alpha3
     * @return BaseBranch
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     *
     * @param int $partner
     * @return BaseBranch
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;
        return $this;
    }
}
