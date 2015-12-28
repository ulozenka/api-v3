<?php

namespace UlozenkaLib\APIv3\Formatter;

use UlozenkaLib\APIv3\Model\ConnectorResponse;
use UlozenkaLib\APIv3\Resource\Consignments\Request\ConsignmentRequest;
use UlozenkaLib\APIv3\Resource\Consignments\Response\CreateConsignmentResponse;
use UlozenkaLib\APIv3\Resource\Labels\Request\LabelRequest;
use UlozenkaLib\APIv3\Resource\Labels\Response\GetLabelsResponse;
use UlozenkaLib\APIv3\Resource\StatusHistory\Response\GetStatusHistoryResponse;
use UlozenkaLib\APIv3\Resource\TransportServices\Branches\Response\GetTransportServiceBranchesResponse;

/**
 * Interface IFormatter
 * @package UlozenkaLib\APIv3\Formatter
 */
interface IFormatter
{

    /**
     *
     * @param ConsignmentRequest $consignmentRequest
     * @return string
     */
    public function formatCreateConsignmentRequest(ConsignmentRequest $consignmentRequest);

    /**
     *
     * @param ConnectorResponse $connectorResponse
     * @return CreateConsignmentResponse
     */
    public function formatCreateConsignmentResponse(ConnectorResponse $connectorResponse);

    /**
     *
     * @param LabelRequest $labelRequest
     * @return string
     */
    public function formatGetLabelsRequest(LabelRequest $labelRequest);

    /**
     *
     * @param ConnectorResponse $connectorResponse
     * @return GetLabelsResponse
     */
    public function formatGetLabelsResponse(ConnectorResponse $connectorResponse);

    /**
     *
     * @param ConnectorResponse $connectorResponse
     * @return GetStatusHistoryResponse
     */
    public function formatGetStatusHistoryResponse(ConnectorResponse $connectorResponse);

    /**
     *
     * @param ConnectorResponse $connectorResponse
     * @return GetTransportServiceBranchesResponse
     */
    public function formatGetTransportServiceBranchesResponse(ConnectorResponse $connectorResponse);


}
