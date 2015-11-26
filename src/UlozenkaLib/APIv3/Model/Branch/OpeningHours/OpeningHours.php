<?php

namespace UlozenkaLib\APIv3\Model\Branch\OpeningHours;

/**
 * Class OpeningHours
 * @package UlozenkaLib\APIv3\Model
 */
class OpeningHours
{

    /** @var RegularOpeningHours */
    protected $regular;

    /** @var array */
    protected $exceptions;

    /**
     *
     * @param RegularOpeningHours|null $regular
     * @param array $exceptions
     */
    public function __construct(RegularOpeningHours $regular = null, $exceptions = [])
    {
        $this->regular = $regular;
        $this->exceptions = $exceptions;
    }

    /**
     *
     * @return RegularOpeningHours|null
     */
    public function getRegular()
    {
        return $this->regular;
    }

    /**
     *
     * @return array
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }
}
