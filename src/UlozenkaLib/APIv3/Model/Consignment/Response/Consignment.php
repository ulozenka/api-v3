<?php

namespace UlozenkaLib\APIv3\Model\Consignment\Response;

use DateTime;
use UlozenkaLib\APIv3\Model\Consignment\BaseConsignment;
use UlozenkaLib\APIv3\Model\Consignment\Status;

/**
 * Class Consignment
 * @package UlozenkaLib\APIv3\Model
 */
class Consignment extends BaseConsignment
{

    /** @var int */
    protected $id;

    /** @var int */
    protected $shopId;

    /** @var string */
    protected $parcelNumber;

    /** @var bool */
    protected $paidByCard;

    /** @var Status */
    protected $status;

    /** @var bool */
    protected $maxStoringDateIncreasedByClient;

    /** @var bool */
    protected $maxStoringDateIncreasedByPartner;

    /** @var DateTime */
    protected $timeCreated;

    /** @var DateTime */
    protected $timeUpdated;

    /** @var DateTime */
    protected $timeReceived;

    /** @var DateTime */
    protected $timeClosed;

    /** @var DateTime */
    protected $timeCodSent;

    /** @var DateTime */
    protected $timeInvoiceSent;

    /** @var DateTime */
    protected $maxStoringDate;

    /** @var string */
    protected $labelsString;

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
     * @return int
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     *
     * @return string
     */
    public function getParcelNumber()
    {
        return $this->parcelNumber;
    }

    /**
     *
     * @return bool
     */
    public function getPaidByCard()
    {
        return $this->paidByCard;
    }

    /**
     *
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     * @return bool
     */
    public function getMaxStoringDateIncreasedByClient()
    {
        return $this->maxStoringDateIncreasedByClient;
    }

    /**
     *
     * @return bool
     */
    public function getMaxStoringDateIncreasedByPartner()
    {
        return $this->maxStoringDateIncreasedByPartner;
    }

    /**
     *
     * @return DateTime
     */
    public function getTimeCreated()
    {
        return $this->timeCreated;
    }

    /**
     *
     * @return DateTime
     */
    public function getTimeUpdated()
    {
        return $this->timeUpdated;
    }

    /**
     *
     * @return DateTime
     */
    public function getTimeReceived()
    {
        return $this->timeReceived;
    }

    /**
     *
     * @return DateTime
     */
    public function getTimeClosed()
    {
        return $this->timeClosed;
    }

    /**
     *
     * @return DateTime
     */
    public function getTimeCodSent()
    {
        return $this->timeCodSent;
    }

    /**
     *
     * @return DateTime
     */
    public function getTimeInvoiceSent()
    {
        return $this->timeInvoiceSent;
    }

    /**
     *
     * @return DateTime
     */
    public function getMaxStoringDate()
    {
        return $this->maxStoringDate;
    }

    /**
     *
     * @return string
     */
    public function getLabelsString()
    {
        return $this->labelsString;
    }

    /**
     *
     * @param int $id
     * @return Consignment
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @param int $shopId
     * @return Consignment
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;
        return $this;
    }

    /**
     *
     * @param string $parcelNumber
     * @return Consignment
     */
    public function setParcelNumber($parcelNumber)
    {
        $this->parcelNumber = $parcelNumber;
        return $this;
    }

    /**
     *
     * @param bool|int $paidByCard
     * @return Consignment
     */
    public function setPaidByCard($paidByCard)
    {
        $this->paidByCard = (bool)$paidByCard;
        return $this;
    }

    /**
     *
     * @param Status $status
     * @return Consignment
     */
    public function setStatus(Status $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     *
     * @param bool|int $maxStoringDateIncreasedByClient
     * @return Consignment
     */
    public function setMaxStoringDateIncreasedByClient($maxStoringDateIncreasedByClient)
    {
        $this->maxStoringDateIncreasedByClient = (bool)$maxStoringDateIncreasedByClient;
        return $this;
    }

    /**
     *
     * @param bool|int $maxStoringDateIncreasedByPartner
     * @return Consignment
     */
    public function setMaxStoringDateIncreasedByPartner($maxStoringDateIncreasedByPartner)
    {
        $this->maxStoringDateIncreasedByPartner = (bool)$maxStoringDateIncreasedByPartner;
        return $this;
    }

    /**
     *
     * @param DateTime $timeCreated
     * @return Consignment
     */
    public function setTimeCreated(DateTime $timeCreated)
    {
        $this->timeCreated = $timeCreated;
        return $this;
    }

    /**
     *
     * @param DateTime $timeUpdated
     * @return Consignment
     */
    public function setTimeUpdated(DateTime $timeUpdated)
    {
        $this->timeUpdated = $timeUpdated;
        return $this;
    }

    /**
     *
     * @param DateTime $timeReceived
     * @return Consignment
     */
    public function setTimeReceived(DateTime $timeReceived = null)
    {
        $this->timeReceived = $timeReceived;
        return $this;
    }

    /**
     *
     * @param DateTime $timeClosed
     * @return Consignment
     */
    public function setTimeClosed(DateTime $timeClosed = null)
    {
        $this->timeClosed = $timeClosed;
        return $this;
    }

    /**
     *
     * @param DateTime $timeCodSent
     * @return Consignment
     */
    public function setTimeCodSent(DateTime $timeCodSent = null)
    {
        $this->timeCodSent = $timeCodSent;
        return $this;
    }

    /**
     *
     * @param DateTime $timeInvoiceSent
     * @return Consignment
     */
    public function setTimeInvoiceSent(DateTime $timeInvoiceSent = null)
    {
        $this->timeInvoiceSent = $timeInvoiceSent;
        return $this;
    }

    /**
     *
     * @param DateTime $maxStoringDate
     * @return Consignment
     */
    public function setMaxStoringDate(DateTime $maxStoringDate = null)
    {
        $this->maxStoringDate = $maxStoringDate;
        return $this;
    }

    /**
     *
     * @param string $labelsString
     * @return Consignment
     */
    public function setLabelsString($labelsString)
    {
        if (!empty($labelsString)) {
            $this->labelsString = trim(base64_decode($labelsString));
        }
        return $this;
    }
}
