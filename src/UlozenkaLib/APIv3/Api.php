<?php
namespace UlozenkaLib\APIv3;

use DateTime;
use UlozenkaLib\APIv3\Enum\Attributes\BranchAttr;
use UlozenkaLib\APIv3\Enum\Attributes\LabelAttr;
use UlozenkaLib\APIv3\Enum\Attributes\StatusHistoryAttr;
use UlozenkaLib\APIv3\Enum\Attributes\TrackingAttr;
use UlozenkaLib\APIv3\Enum\Endpoint;
use UlozenkaLib\APIv3\Enum\Header;
use UlozenkaLib\APIv3\Enum\Method;
use UlozenkaLib\APIv3\Enum\Resource;
use UlozenkaLib\APIv3\Formatter\IFormatter;
use UlozenkaLib\APIv3\Formatter\JsonFormatter;
use UlozenkaLib\APIv3\Model\RequestEnvelope;
use UlozenkaLib\APIv3\Resource\Consignments\Request\ConsignmentRequest;
use UlozenkaLib\APIv3\Resource\Consignments\Response\CreateConsignmentResponse;
use UlozenkaLib\APIv3\Resource\Labels\Request\LabelRequest;
use UlozenkaLib\APIv3\Resource\Labels\Response\GetLabelsResponse;
use UlozenkaLib\APIv3\Resource\StatusHistory\Response\GetStatusHistoryResponse;
use UlozenkaLib\APIv3\Resource\Tracking\Response\GetTrackingResponse;
use UlozenkaLib\APIv3\Resource\TransportServices\Branches\Response\GetTransportServiceBranchesResponse;


/**
 * Class Api
 * @package UlozenkaLib\APIv3
 */
class Api
{

    /** @var Connector */
    private $connector;

    /** @var IFormatter */
    private $formatter;
    private $shopId;
    private $apiKey;
    private $appId;
    private $appVersion;

    /**
     * Api constructor.
     * @param string $endpoint
     * @param string|null $shopId
     * @param string|null $apiKey
     * @param string|null $appId
     * @param string|null $appVersion
     */
    public function __construct($endpoint = Endpoint::PRODUCTION, $shopId = null, $apiKey = null, $appId = null, $appVersion = null)
    {
        $this->connector = new Connector($endpoint);
        $this->shopId = $shopId;
        $this->apiKey = $apiKey;
        $this->appId = $appId;
        $this->appVersion = $appVersion;
        $this->formatter = new JsonFormatter();
    }

    /**
     * @param IFormatter $formatter
     */
    public function setFormatter(IFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @param ConsignmentRequest $consignmentRequest
     * @param string|null $shopId
     * @param string|null $apiKey
     * @return CreateConsignmentResponse
     */
    public function createConsignment(ConsignmentRequest $consignmentRequest, $shopId = null, $apiKey = null)
    {
        $shop = isset($shopId) ? $shopId : $this->shopId;
        $key = isset($apiKey) ? $apiKey : $this->apiKey;
        $resource = Resource::CONSIGNMENTS;
        $data = $this->formatter->formatCreateConsignmentRequest($consignmentRequest);

        $requestEnvelope = new RequestEnvelope($data, $resource, Method::POST, $shop, $key);
        $requestEnvelopeWithHeaders = $this->attachBasicHeadersToRequest($requestEnvelope);
        $connectorResponse = $this->connector->sendRequest($requestEnvelopeWithHeaders);

        $formattedResponse = $this->formatter->formatCreateConsignmentResponse($connectorResponse);

        return $formattedResponse;
    }

    /**
     * @param string[]|int[]|mixed $consignments
     * @param string $type
     * @param int $firstPosition
     * @param int $labelsPerPage
     * @param string|null $shopId
     * @param string|null $apiKey
     * @return GetLabelsResponse
     * @throws \Exception
     */
    public function getLabels($consignments = [], $type = LabelAttr::TYPE_PDF, $firstPosition = 1, $labelsPerPage = 4, $shopId = null, $apiKey = null)
    {
        $shop = isset($shopId) ? $shopId : $this->shopId;
        $key = isset($apiKey) ? $apiKey : $this->apiKey;
        $resource = Resource::LABELS;

        $labelRequest = new LabelRequest($consignments, $type, $firstPosition, $labelsPerPage);
        $data = $this->formatter->formatGetLabelsRequest($labelRequest);

        $requestEnvelope = new RequestEnvelope($data, $resource, Method::POST, $shop, $key);
        $requestEnvelopeWithHeaders = $this->attachBasicHeadersToRequest($requestEnvelope);
        $connectorResponse = $this->connector->sendRequest($requestEnvelopeWithHeaders);

        $formattedResponse = $this->formatter->formatGetLabelsResponse($connectorResponse);

        return $formattedResponse;
    }

    /**
     * @param DateTime|null $timeFrom Statuses that occurred after specified date (you can use either $timeFrom or $publishedFrom, not both)
     * @param DateTime|null $publishedFrom Statuses published in the API after specified date (you can use either $timeFrom or $publishedFrom, not both)
     * @param string|null $shopId
     * @param string|null $apiKey
     * @param int|null $limit
     * @param int|null $offset
     * @param int|null $statusId
     * @return GetStatusHistoryResponse
     */
    public function getStatusHistory(DateTime $timeFrom = null, DateTime $publishedFrom = null, $shopId = null, $apiKey = null, $limit = null, $offset = null, $statusId = null)
    {
        $resource = Resource::STATUSHISTORY;

        $shop = isset($shopId) ? $shopId : $this->shopId;
        $key = isset($apiKey) ? $apiKey : $this->apiKey;

        $queryStringParams = [
            StatusHistoryAttr::QS_TIME_FROM => (isset($timeFrom) ? $timeFrom->format('YmdHis') : null),
            StatusHistoryAttr::QS_PUBLISHED_FROM => (isset($publishedFrom) ? $publishedFrom->format('YmdHis') : null),
            StatusHistoryAttr::QS_STATUS_ID => $statusId,
            StatusHistoryAttr::QS_LIMIT => $limit,
            StatusHistoryAttr::QS_OFFSET => $offset,
        ];
        $queryString = http_build_query($queryStringParams);

        if (mb_strlen($queryString) > 0) {
            $resource .= '?' . $queryString;
        }

        $requestEnvelope = new RequestEnvelope(null, $resource, Method::GET, $shop, $key);
        $requestEnvelopeWithHeaders = $this->attachBasicHeadersToRequest($requestEnvelope);

        $connectorResponse = $this->connector->sendRequest($requestEnvelopeWithHeaders);

        $formattedResponse = $this->formatter->formatGetStatusHistoryResponse($connectorResponse);

        return $formattedResponse;
    }

    /**
     * @param int $transportServiceId
     * @param string|null $shopId
     * @param bool $destinationOnly
     * @param bool $registerOnly
     * @param bool $includeInactive
     * @param string|null $destinationCountry ISO 3166-1 Alpha3
     *
     * @see TransportService for Transport Service ID's
     *
     * @return GetTransportServiceBranchesResponse
     */
    public function getTransportServiceBranches($transportServiceId, $shopId = null, $destinationOnly = false, $registerOnly = false, $includeInactive = false, $destinationCountry = null)
    {
        $resource = Resource::TRANSPORT_SERVICES . '/' . $transportServiceId . Resource::BRANCHES;

        $queryStringParams = [
            BranchAttr::QS_SHOP_ID => $shopId,
            BranchAttr::QS_DESTINATION_ONLY => $destinationOnly,
            BranchAttr::QS_REGISTER_ONLY => $registerOnly,
            BranchAttr::QS_INCLUDE_INACTIVE => $includeInactive,
            BranchAttr::QS_DESTINATION_COUNTRY => $destinationCountry,
        ];
        $queryString = http_build_query($queryStringParams);

        if (mb_strlen($queryString) > 0) {
            $resource .= '?' . $queryString;
        }

        $requestEnvelope = new RequestEnvelope(null, $resource, Method::GET);
        $requestEnvelopeWithHeaders = $this->attachBasicHeadersToRequest($requestEnvelope);

        $connectorResponse = $this->connector->sendRequest($requestEnvelopeWithHeaders);
        $formattedResponse = $this->formatter->formatGetTransportServiceBranchesResponse($connectorResponse);

        return $formattedResponse;
    }

    /**
     * @param string|int $identifier
     * @param string $lang
     * @return GetTrackingResponse
     */
    public function getTracking($identifier, $lang = 'cs')
    {
        $queryStringParams = [
            TrackingAttr::QS_IDENTIFIER => $identifier,
            TrackingAttr::QS_LANG => $lang
        ];

        $resource = Resource::TRACKING;

        $queryString = http_build_query($queryStringParams);
        if (mb_strlen($queryString) > 0) {
            $resource .= '?' . $queryString;
        }

        $requestEnvelope = new RequestEnvelope(null, $resource, Method::GET, $this->shopId, $this->apiKey);
        $requestEnvelopeWithHeaders = $this->attachBasicHeadersToRequest($requestEnvelope);

        $connectorResponse = $this->connector->sendRequest($requestEnvelopeWithHeaders);
        $formattedResponse = $this->formatter->formatGetTrackingResponse($connectorResponse);

        return $formattedResponse;
    }


    /**
     * Disable SSL certificates verification
     * Warning: Use this carefully, not for production use!
     */
    public function disableSslVerification()
    {
        $this->connector->disableSslVerification();
    }

    /**
     *
     * @param RequestEnvelope $requestEnvelope
     * @return RequestEnvelope
     */
    private function attachBasicHeadersToRequest(RequestEnvelope $requestEnvelope)
    {
        $requestEnvelope->setAppIdHeader($this->appId);
        $requestEnvelope->setAppVersionHeader($this->appVersion);
        $requestEnvelope->setContentTypeHeader(Header::FORMAT_APPLICATION_JSON);
        $requestEnvelope->setAcceptHeader(Header::FORMAT_APPLICATION_JSON);
        return $requestEnvelope;
    }
}
