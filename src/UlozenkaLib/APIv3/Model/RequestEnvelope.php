<?php

namespace UlozenkaLib\APIv3\Model;

use UlozenkaLib\APIv3\Enum\Header;
use UlozenkaLib\APIv3\Enum\Library;

/**
 * Class RequestEnvelope
 * @package UlozenkaLib\APIv3\Model
 */
class RequestEnvelope
{

    /** @var array $headers */
    private $headers = [];

    /** @var string $data */
    private $data;

    /** @var string $resource */
    private $resource;

    /** @var string $method */
    private $method;

    public function __construct($data, $resource, $method, $shop = null, $key = null)
    {
        $this->data = $data;
        $this->resource = $resource;
        $this->method = $method;
        $this->setShopHeader($shop);
        $this->setKeyHeader($key);
        $this->setLibraryNameHeader(Library::LIBRARY_NAME);
        $this->setLibraryVersionHeader(Library::LIBRARY_VERSION);
    }

    /**
     *
     * @return array [header_key=>value]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     *
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     *
     * @param string $value
     * @return RequestEnvelope
     */
    public function setShopHeader($value)
    {
        if (!empty($value)) {
            $this->headers[Header::SHOP] = $value;
        }
        return $this;
    }

    /**
     *
     * @param int $value
     * @return RequestEnvelope
     */
    public function setKeyHeader($value)
    {
        if (!empty($value)) {
            $this->headers[Header::KEY] = $value;
        }
        return $this;
    }

    /**
     *
     * @param string $value
     * @return RequestEnvelope
     */
    public function setAppIdHeader($value)
    {
        if (!empty($value)) {
            $this->headers[Header::APP_ID] = $value;
        }
        return $this;
    }

    /**
     *
     * @param string $value
     * @return RequestEnvelope
     */
    public function setAppVersionHeader($value)
    {
        if (!empty($value)) {
            $this->headers[Header::APP_VERSION] = $value;
        }
        return $this;
    }

    /**
     *
     * @param string $value
     * @return RequestEnvelope
     */
    public function setContentTypeHeader($value)
    {
        if (!empty($value)) {
            $this->headers[Header::CONTENT_TYPE] = $value;
        }
        return $this;
    }

    /**
     *
     * @param string $value
     * @return RequestEnvelope
     */
    public function setAcceptHeader($value)
    {
        if (!empty($value)) {
            $this->headers[Header::ACCEPT] = $value;
        }
        return $this;
    }

    /**
     *
     * @param string $value
     * @return RequestEnvelope
     */
    protected function setLibraryNameHeader($value)
    {
        $this->headers[Header::LIBRARY_NAME] = $value;
        return $this;
    }

    /**
     *
     * @param string $value
     * @return RequestEnvelope
     */
    protected function setLibraryVersionHeader($value)
    {
        $this->headers[Header::LIBRARY_VERSION] = $value;
        return $this;
    }
}
