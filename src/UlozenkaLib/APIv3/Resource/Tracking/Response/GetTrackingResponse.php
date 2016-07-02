<?php

namespace UlozenkaLib\APIv3\Resource\Tracking\Response;

use UlozenkaLib\APIv3\Model\BaseResponse;
use UlozenkaLib\APIv3\Model\Tracking\Consignment;
use UlozenkaLib\APIv3\Model\Tracking\Status;
use UlozenkaLib\APIv3\Model\Tracking\Tracking;
use UlozenkaLib\APIv3\Model\Tracking\TransportService;

/**
 * Class Tracking
 * @package UlozenkaLib\APIv3\Model
 */
class GetTrackingResponse extends BaseResponse
{

    /**
     * @return Tracking[]
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return Tracking|null
     */
    public function getTracking()
    {
        $data = $this->getData();
        if (isset($data[0])) {
            return $data[0];
        } else {
            return null;
        }
    }

    /**
     * @return null|Consignment
     */
    public function getConsignment()
    {
        $data = $this->getData();
        if (isset($data[0])) {
            /** @var Tracking */
            return $data[0]->getConsignment();
        } else {
            return null;
        }
    }

    /**
     * @return null|TransportService
     */
    public function getTransportService()
    {
        $data = $this->getData();
        if (isset($data[0])) {
            /** @var Tracking */
            return $data[0]->getTransportService();
        } else {
            return null;
        }
    }

    /**
     * @return Status[]
     */
    public function getStatuses()
    {
        $data = $this->getData();
        if (isset($data[0])) {
            /** @var Tracking */
            return $data[0]->getStatuses();
        } else {
            return [];
        }
    }
}
