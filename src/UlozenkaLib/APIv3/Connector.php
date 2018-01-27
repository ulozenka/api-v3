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

    /** @var array $curlOptions */
    private $curlOptions;

    /** @var string $endpoint */
    private $endpoint;

    public function __construct($endpoint = Endpoint::PRODUCTION)
    {
        $this->endpoint = $endpoint;
        $this->curlOptions[CURLOPT_FOLLOWLOCATION] = false;
    }

    /**
     * Disable SSL certificates verification
     * Warning: Use this carefully, not for production use!
     */
    public function disableSslVerification()
    {
        $this->curlOptions[CURLOPT_SSL_VERIFYHOST] = false;
        $this->curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
    }

    public function setCertificate($certificatePath)
    {
        $this->curlOptions[CURLOPT_CAINFO] = $certificatePath;
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

        try {
            $curlClient = new CurlClient($this->curlOptions);
            $response = $curlClient->process($request);
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
