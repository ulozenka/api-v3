<?php

namespace UlozenkaLib\APIv3\Model\Branch;

/**
 * Class District
 * @package UlozenkaLib\APIv3\Model
 */
class District
{

    /** @var int */
    protected $id;

    /** @var string */
    protected $nutsNumber;

    /** @var string */
    protected $name;

    /**
     *
     * @param int $id
     * @param string $nutsNumber
     * @param string $name
     */
    public function __construct($id, $nutsNumber = null, $name = null)
    {
        $this->id = $id;
        $this->nutsNumber = $nutsNumber;
        $this->name = $name;
    }

    /**
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getNutsNumber()
    {
        return $this->nutsNumber;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param int $id
     * @return District
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @param string $nutsNumber
     * @return District
     */
    public function setNutsNumber($nutsNumber)
    {
        $this->nutsNumber = $nutsNumber;
        return $this;
    }

    /**
     *
     * @param string $name
     * @return District
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
