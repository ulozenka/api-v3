<?php

namespace UlozenkaLib\APIv3\Model\Tracking;

use UlozenkaLib\APIv3\Model\Link;
use UlozenkaLib\APIv3\Model\Tracking\TransportService\DestinationBranch;

/**
 * Class Consignment
 * @package UlozenkaLib\APIv3\Model\Tracking
 */
class TransportService
{

    /** @var Link[] */
    protected $links;

    /** @var int */
    protected $id;

    /** @var  string */
    protected $name;

    /** @var  DestinationBranch */
    protected $destinationBranch;

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
     * @return Link[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param Link[] $links
     * @return TransportService
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
     * @return TransportService
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
     * @return TransportService
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return DestinationBranch
     */
    public function getDestinationBranch()
    {
        return $this->destinationBranch;
    }

    /**
     * @param DestinationBranch $destinationBranch
     * @return TransportService
     */
    public function setDestinationBranch($destinationBranch)
    {
        $this->destinationBranch = $destinationBranch;
        return $this;
    }
}
