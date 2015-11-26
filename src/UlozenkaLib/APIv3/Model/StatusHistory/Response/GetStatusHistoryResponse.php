<?php

namespace UlozenkaLib\APIv3\Model\StatusHistory\Response;

use UlozenkaLib\APIv3\Model\BaseResponse;
use UlozenkaLib\APIv3\Model\StatusHistory\ConsignmentStatus;

/**
 * Class GetStatusHistoryResponse
 * @package UlozenkaLib\APIv3\Model
 */
class GetStatusHistoryResponse extends BaseResponse
{

    /**
     *
     * @return ConsignmentStatus[]
     */
    public function getData()
    {
        return parent::getData();
    }

}
