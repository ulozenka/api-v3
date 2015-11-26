<?php

namespace UlozenkaLib\APIv3\Model\Consignment;

/**
 * Class Subject
 * @package UlozenkaLib\APIv3\Model\Consignment
 */
class Subject
{

    /** @var string */
    private $name;

    /** @var string */
    private $surname;

    /** @var string */
    private $company;

    /** @var Address */
    private $address;

    /** @var string */
    private $email;

    /** @var string */
    private $phone;

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
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     *
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     *
     * @param string $name
     * @return Subject
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @param string $surname
     * @return Subject
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     *
     * @param string $company
     * @return Subject
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     *
     * @param Address $address
     * @return Subject
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     *
     * @param string $email
     * @return Subject
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     *
     * @param string $phone
     * @return Subject
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
}
