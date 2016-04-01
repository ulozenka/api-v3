<?php

namespace UlozenkaLib\APIv3\Resource\Tracking\Response;

use UlozenkaLib\APIv3\Model\BaseResponse;
use UlozenkaLib\APIv3\Model\Tracking\Tracking;

/**
 * Class Tracking
 * @package UlozenkaLib\APIv3\Model
 */
class GetTrackingResponse extends BaseResponse
{

    /**
     * @return Tracking
     */
    public function getData()
    {
        return $this->data;
    }

}
