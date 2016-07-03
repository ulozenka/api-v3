<?php

namespace UlozenkaLib\APIv3\Model\Tracking;

/**
 * Class TransportServiceBranches
 * @package UlozenkaLib\APIv3\Model\Tracking
 */
class Tracking
{

    /** @var Consignment */
    protected $consignment;

    /** @var TransportService */
    protected $transportService;

    /** @var  Status[] */
    protected $statuses;

    /**
     * Tracking constructor.
     * @param Consignment $consignment
     * @param TransportService $transportService
     * @param Status[] $statuses
     */
    public function __construct(Consignment $consignment, TransportService $transportService, $statuses)
    {
        $this->consignment = $consignment;
        $this->transportService = $transportService;
        $this->statuses = $statuses;
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
     * @return TransportService
     */
    public function getTransportService()
    {
        return $this->transportService;
    }

    /**
     * @return Status[]
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

}
