<?php

namespace UlozenkaLib\APIv3\Model;

/**
 * Abstract Class BaseResponse
 * @package UlozenkaLib\APIv3\Model
 */
abstract class BaseResponse
{

    /** @var string */
    protected $rawResponseData;

    /** @var int */
    protected $responseCode;

    /** @var Link[] */
    protected $links;

    /** @var Error[] */
    protected $errors;

    /** @var array|mixed|\stdClass */
    protected $data;

    public function __construct($rawResponseData, $responseCode, array $links = [], array $errors = [], $data = [])
    {
        $this->rawResponseData = $rawResponseData;
        $this->responseCode = $responseCode;
        $this->links = $links;
        $this->errors = $errors;
        $this->data = $data;
    }

    /**
     *
     * @return string
     */
    public function getRawResponseData()
    {
        return $this->rawResponseData;
    }

    /**
     *
     * @return int
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     *
     * @return Link[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     *
     * @return Error[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     *
     * @param string $rawResponseData
     * @return \UlozenkaLib\APIv3\Model\BaseResponse
     */
    public function setRawResponseData($rawResponseData)
    {
        $this->rawResponseData = $rawResponseData;
        return $this;
    }

    /**
     *
     * @param int $responseCode
     * @return \UlozenkaLib\APIv3\Model\BaseResponse
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
        return $this;
    }

    /**
     *
     * @param array $links
     * @return \UlozenkaLib\APIv3\Model\BaseResponse
     */
    public function setLinks(array $links)
    {
        $this->links = $links;
        return $this;
    }

    /**
     *
     * @param array $errors
     * @return \UlozenkaLib\APIv3\Model\BaseResponse
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     *
     * @param array $data
     * @return \UlozenkaLib\APIv3\Model\BaseResponse
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     *
     * @return bool
     */
    public function isSuccess()
    {
        return (isset($this->responseCode) && ($this->responseCode === 200 || $this->responseCode === 201));
    }

    /**
     *
     * @return Link|null
     */
    public function getNextLink()
    {
        foreach ($this->links as $link) {
            if ($link->getResourceName() === \UlozenkaLib\APIv3\Enum\Attributes\LinkAttr::RESOURCE_NEXT) {
                return $link;
            }
        }
        return null;
    }

    /**
     * Is the HATEOAS "next" link set?
     * @return bool
     */
    public function hasNextLink()
    {
        $nextLink = $this->getNextLink();
        return isset($nextLink);
    }

    /**
     * QS params parsed from the HATEOAS "next" link
     * @return array
     * @throws \Exception
     */
    public function getNextLinkQueryStringParams()
    {
        $nextLink = $this->getNextLink();
        if (!isset($nextLink)) {
            throw new \Exception('No HATEOAS \"next\" link provided.');
        }
        $parsedUrl = parse_url($nextLink->getUrl());
        $qsArray = [];
        parse_str($parsedUrl['query'], $qsArray);
        return $qsArray;
    }
}
