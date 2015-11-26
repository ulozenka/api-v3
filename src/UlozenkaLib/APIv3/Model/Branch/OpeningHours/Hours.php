<?php

namespace UlozenkaLib\APIv3\Model\Branch\OpeningHours;

/**
 * Class Hours
 * @package UlozenkaLib\APIv3\Model
 */
class Hours
{

    /** @var string Format: h:i */
    protected $open;

    /** @var string Format: h:i */
    protected $close;

    /**
     *
     * @param string $open Format: h:i
     * @param string $close Format: h:i
     */
    public function __construct($open, $close)
    {
        $this->open = $open;
        $this->close = $close;
    }

    /**
     *
     * @return string Format: h:i
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     *
     * @return string Format: h:i
     */
    public function getClose()
    {
        return $this->close;
    }
}
