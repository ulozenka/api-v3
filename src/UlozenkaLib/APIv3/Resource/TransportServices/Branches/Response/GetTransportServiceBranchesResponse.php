<?php

namespace UlozenkaLib\APIv3\Resource\TransportServices\Branches\Response;

use UlozenkaLib\APIv3\Model\BaseResponse;
use UlozenkaLib\APIv3\Model\TransportService\Branch\DestinationBranch;
use UlozenkaLib\APIv3\Model\TransportService\Branch\RegisterBranch;
use UlozenkaLib\APIv3\Model\TransportService\Branch\TransportServiceBranches;

/**
 * Class GetTransportServiceBranchesResponse
 * @package UlozenkaLib\APIv3\Model
 */
class GetTransportServiceBranchesResponse extends BaseResponse
{

    /**
     * @return TransportServiceBranches
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     *
     * @return DestinationBranch[]
     */
    public function getDestinationBranches()
    {
        return $this->getData()->getDestination();
    }

    /**
     *
     * @return RegisterBranch[]
     */
    public function getRegisterBranches()
    {
        return $this->getData()->getRegister();
    }
}
