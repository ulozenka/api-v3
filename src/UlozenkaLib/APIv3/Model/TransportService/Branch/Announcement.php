<?php

namespace UlozenkaLib\APIv3\Model\TransportService\Branch;

/**
 * Class Announcement
 * @package UlozenkaLib\APIv3\Model
 */
class Announcement
{

    /** @var string */
    protected $title;

    /** @var string */
    protected $text;

    /** @var int */
    protected $priority;

    /**
     *
     * @param string $text
     * @param int $priority
     * @param string $title
     */
    public function __construct($text, $priority, $title = null)
    {
        $this->title = $title;
        $this->text = $text;
        $this->priority = $priority;
    }

    /**
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
