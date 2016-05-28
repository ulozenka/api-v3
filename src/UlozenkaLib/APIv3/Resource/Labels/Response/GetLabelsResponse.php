<?php

namespace UlozenkaLib\APIv3\Resource\Labels\Response;

use UlozenkaLib\APIv3\Model\BaseResponse;
use UlozenkaLib\APIv3\Model\Label\Label;

/**
 * Class GetLabelsResponse
 * @package UlozenkaLib\APIv3\Model
 */
class GetLabelsResponse extends BaseResponse
{

    /**
     * @return Label[]
     */
    public function getData()
    {
        return parent::getData();
    }

    /**
     * @return string|null
     */
    public function getLabelsString()
    {
        $data = $this->getData();
        if (isset($data[0])) {
            return $data[0]->getLabelString();
        } else {
            return null;
        }
    }

}
