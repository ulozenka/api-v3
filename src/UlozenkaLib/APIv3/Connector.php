<?php

namespace UlozenkaLib\APIv3;

use Bitbang\Http\Clients\CurlClient;
use Bitbang\Http\Request;
use Exception;
use UlozenkaLib\APIv3\Enum\Endpoint;
use UlozenkaLib\APIv3\Model\ConnectorResponse;
use UlozenkaLib\APIv3\Model\RequestEnvelope;

/**
 * Class Connector
 * @package UlozenkaLib\APIv3
 */
class Connector
{

    /** @var string $endpoint */
    private $endpoint;

    public function __construct($endpoint = Endpoint::PRODUCTION)
    {
        $this->endpoint = $endpoint;
    }

    /**
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     *
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     *
     * @param RequestEnvelope $requestEnvelope
     * @return ConnectorResponse
     * @throws Exception
     */
    public function sendRequest(RequestEnvelope $requestEnvelope)
    {

        $url = $this->getEndpoint() . $requestEnvelope->getResource();

        $request = new Request($requestEnvelope->getMethod(), $url, $requestEnvelope->getHeaders(), $requestEnvelope->getData());

        $curlOptions = [
            CURLOPT_FOLLOWLOCATION => false,
        ];

        try {
            $curlClient = new CurlClient($curlOptions);
            $response = $curlClient->request($request);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode(), $ex->getPrevious());
        }

        $responseCode = $response->getCode();
        $rawResponseData = $response->getBody();
        $responseHeaders = $response->getHeaders();

        $connectorResponse = new ConnectorResponse($responseCode, $rawResponseData, $responseHeaders);
        return $connectorResponse;
    }
}
