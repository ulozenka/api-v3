<?php

namespace UlozenkaLib\APIv3\Model\Consignment\Response;

use UlozenkaLib\APIv3\Model\BaseResponse;

/**
 * Class CreateConsignmentResponse
 * @package UlozenkaLib\APIv3\Model
 */
class CreateConsignmentResponse extends BaseResponse
{

    /**
     *
     * @return Consignment[]
     */
    public function getData()
    {
        return parent::getData();
    }

    /**
     *
     * @return Consignment|null
     */
    public function getConsignment()
    {
        $data = $this->getData();
        if (isset($data[0])) {
            return $data[0];
        } else {
            return null;
        }
    }
}
