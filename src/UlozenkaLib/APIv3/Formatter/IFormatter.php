<?php

namespace UlozenkaLib\APIv3\Formatter;

use UlozenkaLib\APIv3\Model\ConnectorResponse;
use UlozenkaLib\APIv3\Model\Consignment\Request\ConsignmentRequest;
use UlozenkaLib\APIv3\Model\Consignment\Response\CreateConsignmentResponse;
use UlozenkaLib\APIv3\Model\StatusHistory\Response\GetStatusHistoryResponse;
use UlozenkaLib\APIv3\Model\TransportServices\Branches\Response\GetTransportServiceBranchesResponse;

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
     * @param ConnectorResponse $connectorResponse
     * @return GetTransportServiceBranchesResponse
     */
    public function formatGetTransportServiceBranchesResponse(ConnectorResponse $connectorResponse);

    /**
     *
     * @param ConnectorResponse $connectorResponse
     * @return GetStatusHistoryResponse
     */
    public function formatGetStatusHistoryResponse(ConnectorResponse $connectorResponse);
}
