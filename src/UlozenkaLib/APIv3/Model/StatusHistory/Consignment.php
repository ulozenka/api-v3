<?php

namespace UlozenkaLib\APIv3\Model\StatusHistory;

use UlozenkaLib\APIv3\Model\Link;

/**
 * Class Consignment
 * @package UlozenkaLib\APIv3\Model
 */
class Consignment
{

    /** @var Link[] */
    protected $links;

    /** @var int */
    protected $id;

    /** @var string */
    protected $partnerConsignmentId;

    /** @var string */
    protected $orderNumber;

    /**
     *
     * @param Link[] $links
     * @param int $id
     * @param string $partnerConsignmentId
     * @param string $orderNumber
     */
    public function __construct(array $links, $id, $partnerConsignmentId = null, $orderNumber = null)
    {
        $this->links = $links;
        $this->id = $id;
        $this->partnerConsignmentId = $partnerConsignmentId;
        $this->orderNumber = $orderNumber;
    }

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
    public function getPartnerConsignmentId()
    {
        return $this->partnerConsignmentId;
    }

    /**
     *
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     *
     * @param Link[] $links
     * @return Consignment
     */
    public function setLinks(array $links)
    {
        $this->links = $links;
        return $this;
    }

    /**
     *
     * @param int $id
     * @return Consignment
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @param string $partnerConsignmentId
     * @return Consignment
     */
    public function setPartnerConsignmentId($partnerConsignmentId)
    {
        $this->partnerConsignmentId = $partnerConsignmentId;
        return $this;
    }

    /**
     *
     * @param string $orderNumber
     * @return Consignment
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }
}
