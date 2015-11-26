<?php

namespace UlozenkaLib\APIv3\Model\StatusHistory;

use DateTime;

/**
 * Class ConsignmentStatus
 * @package UlozenkaLib\APIv3\Model\StatusHistory
 */
class ConsignmentStatus
{

    /** @var Consignment */
    protected $consignment;

    /** @var Status */
    protected $status;

    /** @var DateTime */
    protected $datetime;

    /**
     *
     * @param Consignment $consignment
     * @param Status $status
     * @param DateTime $datetime
     */
    public function __construct(Consignment $consignment, Status $status, DateTime $datetime)
    {
        $this->consignment = $consignment;
        $this->status = $status;
        $this->datetime = $datetime;
    }

    /**
     *
     * @return Consignment
     */
    public function getConsignment()
    {
        return $this->consignment;
    }

    /**
     *
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }
}
