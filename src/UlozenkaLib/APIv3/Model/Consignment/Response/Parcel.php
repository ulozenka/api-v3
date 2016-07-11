<?php

namespace UlozenkaLib\APIv3\Model\Consignment\Response;

/**
 * Description of Parcel
 *
 * @author Petr Vácha <petr.vacha@ulozenka.cz>
 */
class Parcel
{

    /** @var int Parcel order */
    private $order;

    /** @var string Parcel barcode */
    private $barcode;

    /**
     *
     * @param int $order
     * @param string $barcode
     */
    public function __construct($order, $barcode)
    {
        $this->order = $order;
        $this->barcode = $barcode;
    }

    /**
     *
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     *
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }
}
