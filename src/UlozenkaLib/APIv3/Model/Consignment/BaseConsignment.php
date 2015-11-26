<?php

namespace UlozenkaLib\APIv3\Model\Consignment;

/**
 * Abstract Class BaseConsignment
 * @package UlozenkaLib\APIv3\Model
 */
abstract class BaseConsignment
{

    /** @var Receiver */
    protected $receiver;

    /** @var string */
    protected $destinationCountry;

    /** @var string */
    protected $orderNumber;

    /** @var string */
    protected $partnerConsignmentId;

    /** @var string */
    protected $variable;

    /** @var int */
    protected $parcelCount;

    /** @var float */
    protected $cashOnDelivery;

    /** @var float */
    protected $insurance;

    /** @var float */
    protected $statedPrice;

    /** @var string ISO 4217 Alpha3 code  */
    protected $currency;

    /** @var int */
    protected $transportServiceId;

    /** @var int */
    protected $registerBranchId;

    /** @var int */
    protected $destinationBranchId;

    /** @var float */
    protected $weight;

    /** @var bool */
    protected $requireFullAge;

    /** @var bool */
    protected $allowCardPayment;

    /** @var string */
    protected $note;

    /**
     *
     * @return Receiver
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     *
     * @return string
     */
    public function getDestinationCountry()
    {
        return $this->destinationCountry;
    }

    /**
     *
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     *
     * @return string
     */
    public function getPartnerConsignmentId()
    {
        return $this->partnerConsignmentId;
    }

    /**
     *
     * @return string
     */
    public function getVariable()
    {
        return $this->variable;
    }

    /**
     *
     * @return int
     */
    public function getParcelCount()
    {
        return $this->parcelCount;
    }

    /**
     *
     * @return float
     */
    public function getCashOnDelivery()
    {
        return $this->cashOnDelivery;
    }

    /**
     *
     * @return float
     */
    public function getInsurance()
    {
        return $this->insurance;
    }

    /**
     *
     * @return float
     */
    public function getStatedPrice()
    {
        return $this->statedPrice;
    }

    /**
     *
     * @return string ISO 4217 Alpha3 code
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     *
     * @return int
     */
    public function getTransportServiceId()
    {
        return $this->transportServiceId;
    }

    /**
     *
     * @return int
     */
    public function getRegisterBranchId()
    {
        return $this->registerBranchId;
    }

    /**
     *
     * @return int
     */
    public function getDestinationBranchId()
    {
        return $this->destinationBranchId;
    }

    /**
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     *
     * @return bool
     */
    public function getRequireFullAge()
    {
        return $this->requireFullAge;
    }

    /**
     *
     * @return bool
     */
    public function getAllowCardPayment()
    {
        return $this->allowCardPayment;
    }

    /**
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     *
     * @param Receiver $receiver
     * @return BaseConsignment
     */
    public function setReceiver(Receiver $receiver)
    {
        $this->receiver = $receiver;
        return $this;
    }

    /**
     *
     * @param string $destinationCountry ISO 3166-1 Alpha3 Code
     * @return BaseConsignment
     */
    public function setDestinationCountry($destinationCountry)
    {
        $this->destinationCountry = $destinationCountry;
        return $this;
    }

    /**
     *
     * @param string $orderNumber
     * @return BaseConsignment
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    /**
     *
     * @param string $partnerConsignmentId
     * @return BaseConsignment
     */
    public function setPartnerConsignmentId($partnerConsignmentId)
    {
        $this->partnerConsignmentId = $partnerConsignmentId;
        return $this;
    }

    /**
     *
     * @param string $variable
     * @return BaseConsignment
     */
    public function setVariable($variable)
    {
        $this->variable = $variable;
        return $this;
    }

    /**
     *
     * @param int $parcelCount
     * @return BaseConsignment
     */
    public function setParcelCount($parcelCount)
    {
        $this->parcelCount = $parcelCount;
        return $this;
    }

    /**
     *
     * @param float $cashOnDelivery
     * @return BaseConsignment
     */
    public function setCashOnDelivery($cashOnDelivery)
    {
        $this->cashOnDelivery = $cashOnDelivery;
        return $this;
    }

    /**
     *
     * @param float $insurance
     * @return BaseConsignment
     */
    public function setInsurance($insurance)
    {
        $this->insurance = $insurance;
        return $this;
    }

    /**
     *
     * @param float $statedPrice
     * @return BaseConsignment
     */
    public function setStatedPrice($statedPrice)
    {
        $this->statedPrice = $statedPrice;
        return $this;
    }

    /**
     *
     * @param string $currency ISO 4217 Alpha3 code
     * @return BaseConsignment
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     *
     * @param int $transportServiceId
     * @return BaseConsignment
     */
    public function setTransportServiceId($transportServiceId)
    {
        $this->transportServiceId = $transportServiceId;
        return $this;
    }

    /**
     *
     * @param int $registerBranchId
     * @return BaseConsignment
     */
    public function setRegisterBranchId($registerBranchId)
    {
        $this->registerBranchId = $registerBranchId;
        return $this;
    }

    /**
     *
     * @param int $destinationBranchId
     * @return BaseConsignment
     */
    public function setDestinationBranchId($destinationBranchId)
    {
        $this->destinationBranchId = $destinationBranchId;
        return $this;
    }

    /**
     *
     * @param float $weight
     * @return BaseConsignment
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     *
     * @param bool|int $requireFullAge
     * @return BaseConsignment
     */
    public function setRequireFullAge($requireFullAge)
    {
        $this->requireFullAge = (bool) $requireFullAge;
        return $this;
    }

    /**
     *
     * @param bool|int  $allowCardPayment
     * @return BaseConsignment
     */
    public function setAllowCardPayment($allowCardPayment)
    {
        $this->allowCardPayment = (bool) $allowCardPayment;
        return $this;
    }

    /**
     *
     * @param string $note
     * @return BaseConsignment
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }
}
