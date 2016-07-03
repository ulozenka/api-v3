<?php

namespace UlozenkaLib\APIv3\Model\Tracking;

use UlozenkaLib\APIv3\Model\Link;

/**
 * Class Status
 * @package UlozenkaLib\APIv3\Model\Tracking
 */
class Status
{

    /** @var Link[] */
    protected $links;

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $trackingName;

    /** @var  \DateTime */
    protected $date;

    /**
     * Status constructor.
     * @param Link[] $links
     * @param int $id
     * @param string $name
     * @param string $trackingName
     * @param \DateTime $date
     */
    public function __construct(array $links, $id, $name, $trackingName, $date)
    {
        $this->links = $links;
        $this->id = $id;
        $this->name = $name;
        $this->trackingName = $trackingName;
        $this->date = $date;
    }

    /**
     * @return \UlozenkaLib\APIv3\Model\Link[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param \UlozenkaLib\APIv3\Model\Link[] $links
     *
     * @return Status
     */
    public function setLinks($links)
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Status
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Status
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTrackingName()
    {
        return $this->trackingName;
    }

    /**
     * @param string $trackingName
     *
     * @return Status
     */
    public function setTrackingName($trackingName)
    {
        $this->trackingName = $trackingName;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return Status
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

}
