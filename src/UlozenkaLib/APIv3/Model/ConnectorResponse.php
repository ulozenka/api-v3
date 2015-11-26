<?php

namespace UlozenkaLib\APIv3\Model;

/**
 * Class ConnectorResponse
 * @package UlozenkaLib\APIv3\Model
 */
class ConnectorResponse
{

    /** @var int $responseCode */
    private $responseCode;

    /** @var array $responseHeaders */
    private $responseHeaders;

    /** @var string $rawResponseData */
    private $rawResponseData;

    /**
     *
     * @param int $responseCode
     * @param string $rawResponseData
     */
    public function __construct($responseCode, $rawResponseData, $responseHeaders = [])
    {
        $this->responseCode = $responseCode;
        $this->rawResponseData = $rawResponseData;
        $this->responseHeaders = $responseHeaders;
    }

    /**
     *
     * @return string
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     *
     * @return array
     */
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     *
     * @return string
     */
    public function getRawResponseData()
    {
        return $this->rawResponseData;
    }
}
