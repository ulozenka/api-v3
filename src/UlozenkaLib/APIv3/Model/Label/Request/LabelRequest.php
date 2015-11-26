<?php

namespace UlozenkaLib\APIv3\Model\Label\Request;

use UlozenkaLib\APIv3\Enum\Attributes\LabelAttr;

/**
 * Class LabelRequest
 * @package UlozenkaLib\APIv3\Model
 */
class LabelRequest
{

    /** @var string */
    protected $type;

    /** @var int */
    protected $firstPosition;

    /** @var int */
    protected $labelsPerPage;

    /** @var bool */
    protected $forceEncoding;

    /** @var string[] */
    protected $consignments;

    /**
     *
     * @param string $consignments
     * @param int $type
     * @param int $firstPosition
     * @param int $labelsPerPage
     * @param bool $forceEncoding
     */
    public function __construct($consignments = [], $type = LabelAttr::TYPE_PDF, $firstPosition = 1, $labelsPerPage = 4, $forceEncoding = true)
    {
        $this->type = $type;
        $this->firstPosition = $firstPosition;
        $this->labelsPerPage = $labelsPerPage;
        $this->forceEncoding = $forceEncoding;
        $this->consignments = $consignments;
    }

    /**
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @return int
     */
    public function getFirstPosition()
    {
        return $this->firstPosition;
    }

    /**
     *
     * @return int
     */
    public function getLabelsPerPage()
    {
        return $this->labelsPerPage;
    }

    /**
     *
     * @return bool
     */
    public function getForceEncoding()
    {
        return $this->forceEncoding;
    }

    /**
     *
     * @return string[]
     */
    public function getConsignments()
    {
        return $this->consignments;
    }

    /**
     *
     * @param string $type
     * @return LabelRequest
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     *
     * @param int $firstPosition
     * @return LabelRequest
     */
    public function setFirstPosition($firstPosition)
    {
        $this->firstPosition = $firstPosition;
        return $this;
    }

    /**
     *
     * @param int $labelsPerPage
     * @return LabelRequest
     */
    public function setLabelsPerPage($labelsPerPage)
    {
        $this->labelsPerPage = $labelsPerPage;
        return $this;
    }

    /**
     *
     * @param bool|int $forceEncoding
     * @return LabelRequest
     */
    public function setForceEncoding($forceEncoding)
    {
        $this->forceEncoding = (bool) $forceEncoding;
        return $this;
    }

    /**
     *
     * @param string[] $consignments
     * @return LabelRequest
     */
    public function setConsignments($consignments)
    {
        $this->consignments = $consignments;
        return $this;
    }
}
