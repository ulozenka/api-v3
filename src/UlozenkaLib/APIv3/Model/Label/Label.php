<?php

namespace UlozenkaLib\APIv3\Model\Label;

/**
 * Class Label
 * @package UlozenkaLib\APIv3\Model
 */
class Label
{


    /** @var string */
    protected $labelString;

    /**
     * Label constructor.
     * @param string $labelString
     */
    public function __construct($labelString = null)
    {
        $this->labelString = $labelString;
    }

    /**
     * @return string
     */
    public function getLabelString()
    {
        return $this->labelString;
    }

    /**
     * @param string $labelString
     * @return Label
     */
    public function setLabelString($labelString)
    {
        $this->labelString = $labelString;
        return $this;
    }


}
