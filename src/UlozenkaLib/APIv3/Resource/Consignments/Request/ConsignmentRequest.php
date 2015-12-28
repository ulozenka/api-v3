<?php

namespace UlozenkaLib\APIv3\Resource\Consignments\Request;

use UlozenkaLib\APIv3\Enum\Attributes\LabelAttr;
use UlozenkaLib\APIv3\Model\Consignment\BaseConsignment;
use UlozenkaLib\APIv3\Model\Consignment\Parcel;
use UlozenkaLib\APIv3\Model\Consignment\Receiver;
use UlozenkaLib\APIv3\Resource\Labels\Request\LabelRequest;

/**
 * Class ConsignmentRequest
 * @package UlozenkaLib\APIv3\Model
 */
class ConsignmentRequest extends BaseConsignment
{

    /** @var LabelRequest */
    private $labelRequest;

    /** @var Parcel[] */
    private $parcels = [];

    /**
     *
     * @param Receiver $receiver
     * @param string $orderNumber
     * @param int $parcelCount
     * @param int $transportServiceId
     */
    public function __construct(Receiver $receiver, $orderNumber, $parcelCount, $transportServiceId)
    {
        $this->receiver = $receiver;
        $this->orderNumber = $orderNumber;
        $this->parcelCount = $parcelCount;
        $this->transportServiceId = $transportServiceId;
    }

    /**
     * @param string $type
     * @param int $firstPosition
     * @param int $labelsPerPage
     * @param bool $forceEncoding
     * @return \UlozenkaLib\APIv3\Resources\Consignments\Request\ConsignmentRequest
     */
    public function requireLabel($type = LabelAttr::TYPE_ZPL, $firstPosition = 1, $labelsPerPage = 4, $forceEncoding = true)
    {
        $labelRequest = new LabelRequest([], $type, $firstPosition, $labelsPerPage, $forceEncoding);
        $this->labelRequest = $labelRequest;
        return $this;
    }

    /**
     * @return LabelRequest
     */
    public function getLabelRequest()
    {
        return $this->labelRequest;
    }

    /**
     *
     * @return Parcel[]
     */
    public function getParcels()
    {
        return $this->parcels;
    }

    /**
     *
     * @param LabelRequest $labelRequest
     * @return ConsignmentRequest
     */
    public function setLabelRequest(LabelRequest $labelRequest)
    {
        $this->labelRequest = $labelRequest;
        return $this;
    }

    /**
     *
     * @param Parcel[] $parcels
     * @return ConsignmentRequest
     */
    public function setParcels($parcels)
    {
        $this->parcels = $parcels;
        return $this;
    }
}
