<?php

namespace UlozenkaLib\APIv3\Model\TransportService\Branch;

/**
 * Class DestinationBranch
 * @package UlozenkaLib\APIv3\Model
 */
class DestinationBranch extends Branch
{

    /** @var bool */
    protected $active;

    /** @var bool */
    protected $preparing;

    /** @var AllowedConsignmentTypes */
    protected $allowedConsignmentTypes;

    /** @var Announcement[] */
    protected $announcements;

    /**
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     *
     * @return bool
     */
    public function getPreparing()
    {
        return $this->preparing;
    }

    /**
     *
     * @return AllowedConsignmentTypes
     */
    public function getAllowedConsignmentTypes()
    {
        return $this->allowedConsignmentTypes;
    }

    /**
     *
     * @return Announcement[]
     */
    public function getAnnouncements()
    {
        return $this->announcements;
    }

    /**
     *
     * @param bool|int $active
     * @return DestinationBranch
     */
    public function setActive($active)
    {
        $this->active = (bool)$active;
        return $this;
    }

    /**
     *
     * @param bool|int $preparing
     * @return DestinationBranch
     */
    public function setPreparing($preparing)
    {
        $this->preparing = (bool)$preparing;
        return $this;
    }

    /**
     *
     * @param AllowedConsignmentTypes $allowedConsignmentTypes
     * @return DestinationBranch
     */
    public function setAllowedConsignmentTypes(AllowedConsignmentTypes $allowedConsignmentTypes)
    {
        $this->allowedConsignmentTypes = $allowedConsignmentTypes;
        return $this;
    }

    /**
     *
     * @param array $announcements
     * @return DestinationBranch
     */
    public function setAnnouncements(array $announcements)
    {
        $this->announcements = $announcements;
        return $this;
    }
}
