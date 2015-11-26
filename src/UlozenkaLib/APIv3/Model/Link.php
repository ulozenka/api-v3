<?php

namespace UlozenkaLib\APIv3\Model;

/**
 * Class Link
 * @package UlozenkaLib\APIv3\Model
 */
class Link
{

    /** @var string */
    protected $resourceName;

    /** @var string */
    protected $url;

    /**
     *
     * @param string $resourceName
     * @param string $url
     */
    public function __construct($resourceName, $url)
    {
        $this->resourceName = $resourceName;
        $this->url = $url;
    }

    /**
     *
     * @return string
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
