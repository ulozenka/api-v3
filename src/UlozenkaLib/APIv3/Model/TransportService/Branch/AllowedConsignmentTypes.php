<?php

namespace UlozenkaLib\APIv3\Model\TransportService\Branch;

/**
 * Class AllowedConsignmentTypes
 * @package UlozenkaLib\APIv3\Model
 */
class AllowedConsignmentTypes
{

    /** @var bool */
    private $standardConsignment;

    /** @var bool */
    private $backwardConsignment;

    /**
     *
     * @param bool $standardConsignment
     * @param bool $backwardConsignment
     */
    public function __construct($standardConsignment, $backwardConsignment)
    {
        $this->setStandardConsignment($standardConsignment);
        $this->setBackwardConsignment($backwardConsignment);
    }

    /**
     *
     * @return bool
     */
    public function getStandardConsignment()
    {
        return $this->standardConsignment;
    }

    /**
     *
     * @return bool
     */
    public function getBackwardConsignment()
    {
        return $this->backwardConsignment;
    }

    /**
     *
     * @param bool|int $standardConsignment
     * @return AllowedConsignmentTypes
     */
    public function setStandardConsignment($standardConsignment)
    {
        $this->standardConsignment = (bool)$standardConsignment;
        return $this;
    }

    /**
     *
     * @param bool|int $backwardConsignment
     * @return AllowedConsignmentTypes
     */
    public function setBackwardConsignment($backwardConsignment)
    {
        $this->backwardConsignment = (bool)$backwardConsignment;
        return $this;
    }
}
