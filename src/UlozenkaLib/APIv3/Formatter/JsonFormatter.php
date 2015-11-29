<?php

namespace UlozenkaLib\APIv3\Formatter;

use DateTime;
use DateTimeZone;
use Exception;
use stdClass;
use UlozenkaLib\APIv3\Enum\Attributes\BranchAttr;
use UlozenkaLib\APIv3\Enum\Attributes\ConsignmentAttr;
use UlozenkaLib\APIv3\Enum\Attributes\DateTimeAttr;
use UlozenkaLib\APIv3\Enum\Attributes\ErrorAttr;
use UlozenkaLib\APIv3\Enum\Attributes\LabelAttr;
use UlozenkaLib\APIv3\Enum\Attributes\LinkAttr;
use UlozenkaLib\APIv3\Enum\Attributes\ParcelAttr;
use UlozenkaLib\APIv3\Enum\Attributes\ResponseAttr;
use UlozenkaLib\APIv3\Exception\Json\ControlCharacterException;
use UlozenkaLib\APIv3\Exception\Json\JsonException;
use UlozenkaLib\APIv3\Exception\Json\MalformedUtf8Exception;
use UlozenkaLib\APIv3\Exception\Json\StackDepthException;
use UlozenkaLib\APIv3\Exception\Json\StateMismatchException;
use UlozenkaLib\APIv3\Exception\Json\SyntaxErrorException;
use UlozenkaLib\APIv3\Model\Branch\District;
use UlozenkaLib\APIv3\Model\Branch\Gps;
use UlozenkaLib\APIv3\Model\Branch\Navigation;
use UlozenkaLib\APIv3\Model\Branch\OpeningHours\Hours;
use UlozenkaLib\APIv3\Model\Branch\OpeningHours\OpeningHours;
use UlozenkaLib\APIv3\Model\Branch\OpeningHours\RegularOpeningHours;
use UlozenkaLib\APIv3\Model\ConnectorResponse;
use UlozenkaLib\APIv3\Model\Consignment\Address;
use UlozenkaLib\APIv3\Model\Consignment\Receiver;
use UlozenkaLib\APIv3\Model\Consignment\Request\ConsignmentRequest;
use UlozenkaLib\APIv3\Model\Consignment\Response\Consignment;
use UlozenkaLib\APIv3\Model\Consignment\Response\CreateConsignmentResponse;
use UlozenkaLib\APIv3\Model\Consignment\Status as CreateConsignmentStatus;
use UlozenkaLib\APIv3\Model\Error;
use UlozenkaLib\APIv3\Model\Link;
use UlozenkaLib\APIv3\Model\StatusHistory\Consignment as StatusHistoryConsignment;
use UlozenkaLib\APIv3\Model\StatusHistory\ConsignmentStatus;
use UlozenkaLib\APIv3\Model\StatusHistory\Response\GetStatusHistoryResponse;
use UlozenkaLib\APIv3\Model\StatusHistory\Status;
use UlozenkaLib\APIv3\Model\TransportServices\Branches\AllowedConsignmentTypes;
use UlozenkaLib\APIv3\Model\TransportServices\Branches\Announcement;
use UlozenkaLib\APIv3\Model\TransportServices\Branches\DestinationBranch;
use UlozenkaLib\APIv3\Model\TransportServices\Branches\RegisterBranch;
use UlozenkaLib\APIv3\Model\TransportServices\Branches\RegisterBranch\Destination;
use UlozenkaLib\APIv3\Model\TransportServices\Branches\Response\GetTransportServiceBranchesResponse;
use UlozenkaLib\APIv3\Model\TransportServices\Branches\TransportServiceBranches;

/**
 * Class JsonFormatter
 * @package UlozenkaLib\lozenkaApi\Formatter
 */
class JsonFormatter implements IFormatter
{

    /**
     *
     * @param ConsignmentRequest $consignmentRequest
     * @return string
     */
    public function formatCreateConsignmentRequest(ConsignmentRequest $consignmentRequest)
    {
        $root = [];

        $this->createAttributeIfHasValue($root, ConsignmentAttr::ORDER_NUMBER, $consignmentRequest->getOrderNumber());
        $this->createAttributeIfHasValue($root, ConsignmentAttr::PARTNER_CONSIGNMENT_ID, $consignmentRequest->getPartnerConsignmentId());
        $this->createAttributeIfHasValue($root, ConsignmentAttr::TRANSPORT_SERVICE_ID, $consignmentRequest->getTransportServiceId());
        $this->createAttributeIfHasValue($root, ConsignmentAttr::ADDRESS_STATE, $consignmentRequest->getDestinationCountry());
        $this->createAttributeIfHasValue($root, ConsignmentAttr::DESTINATION_BRANCH_ID, $consignmentRequest->getDestinationBranchId());
        $this->createAttributeIfHasValue($root, ConsignmentAttr::REGISTER_BRANCH_ID, $consignmentRequest->getRegisterBranchId());
        $this->createAttributeIfHasValue($root, ConsignmentAttr::PARCEL_COUNT, $consignmentRequest->getParcelCount());

        $receiver = $consignmentRequest->getReceiver();
        if (isset($receiver)) {
            // create receiver subattributes
            $this->createAttributeIfHasValue($root, ConsignmentAttr::CUSTOMER_NAME, $receiver->getName());
            $this->createAttributeIfHasValue($root, ConsignmentAttr::CUSTOMER_SURNAME, $receiver->getSurname());
            $this->createAttributeIfHasValue($root, ConsignmentAttr::COMPANY_NAME, $receiver->getCompany());

            $address = $receiver->getAddress();
            if (isset($address)) {
                $this->createAttributeIfHasValue($root, ConsignmentAttr::ADDRESS_STREET, $address->getStreetWithNumber());
                $this->createAttributeIfHasValue($root, ConsignmentAttr::ADDRESS_TOWN, $address->getTown());
                $this->createAttributeIfHasValue($root, ConsignmentAttr::ADDRESS_ZIP, $address->getZip());
            }

            $this->createAttributeIfHasValue($root, ConsignmentAttr::CUSTOMER_PHONE, $receiver->getPhone());
            $this->createAttributeIfHasValue($root, ConsignmentAttr::CUSTOMER_EMAIL, $receiver->getEmail());
        }
        $this->createAttributeIfHasValue($root, ConsignmentAttr::WEIGHT, $consignmentRequest->getWeight());
        $this->createAttributeIfHasValue($root, ConsignmentAttr::CASH_ON_DELIVERY, $consignmentRequest->getCashOnDelivery());
        $this->createAttributeIfHasValue($root, ConsignmentAttr::INSURANCE, $consignmentRequest->getInsurance());
        $this->createAttributeIfHasValue($root, ConsignmentAttr::STATED_PRICE, $consignmentRequest->getStatedPrice());
        $this->createAttributeIfHasValue($root, ConsignmentAttr::CURRENCY, $consignmentRequest->getCurrency());
        $this->createAttributeIfHasValue($root, ConsignmentAttr::VARIABLE, $consignmentRequest->getVariable());

        $this->createAttributeIfHasValue($root, ConsignmentAttr::NOTE, $consignmentRequest->getNote());
        $this->createAttributeIfHasValue($root, ConsignmentAttr::ALLOW_CARD_PAYMENT, intval($consignmentRequest->getAllowCardPayment()));
        $this->createAttributeIfHasValue($root, ConsignmentAttr::REQUIRE_FULL_AGE, intval($consignmentRequest->getRequireFullAge()));

        $parcels = $consignmentRequest->getParcels();
        if (isset($parcels)) {
            $parcelsAttribute = [];
            foreach ($parcels as $parcel) {
                $parcelAttribute = [];
                $this->createAttributeIfHasValue($parcelAttribute, ParcelAttr::PARCEL_NUMBER, $parcel->getParcelNumber());
                if (!empty($parcelAttribute)) {
                    $parcelsAttribute[] = $parcelAttribute;
                }
            }
            $this->createAttributeIfHasValue($root, ConsignmentAttr::PARCELS, $parcelsAttribute);
        }

        $labelRequest = $consignmentRequest->getLabelRequest();
        if (isset($labelRequest)) {
            $labelsAttribute = [];
            $this->createAttributeIfHasValue($labelsAttribute, LabelAttr::TYPE, $labelRequest->getType());
            $this->createAttributeIfHasValue($labelsAttribute, LabelAttr::FIRST_POSITION, $labelRequest->getFirstPosition());
            $this->createAttributeIfHasValue($labelsAttribute, LabelAttr::LABELS_PER_PAGE, $labelRequest->getLabelsPerPage());
            $this->createAttributeIfHasValue($labelsAttribute, LabelAttr::FORCE_ENCODING, $labelRequest->getForceEncoding() ? 1 : 0);
            $this->createAttributeIfHasValue($root, ConsignmentAttr::LABELS, $labelsAttribute);
        }

        return json_encode($root);
    }

    /**
     *
     * @param ConnectorResponse $connectorResponse
     */
    public function formatCreateConsignmentResponse(ConnectorResponse $connectorResponse)
    {
        $rawResponseData = $connectorResponse->getRawResponseData();
        $responseCode = $connectorResponse->getResponseCode();

        try {
            $jsonObject = $this->jsonValidateAndDecode($rawResponseData);
        } catch (JsonException $ex) {
            throw new \Exception('Ulozenka API did not respond with valid JSON.');
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        $data = $this->proccessConsignmentsResponseData($jsonObject);
        $errors = $this->proccessResponseErrors($jsonObject);
        $links = $this->proccessLinks($this->getJsonAttr($jsonObject, ResponseAttr::LINKS));

        $response = new CreateConsignmentResponse($rawResponseData, $responseCode, $links, $errors, $data);
        return $response;
    }

    /**
     *
     * @param ConnectorResponse $connectorResponse
     * @return GetTransportServiceBranchesResponse
     */
    public function formatGetTransportServiceBranchesResponse(ConnectorResponse $connectorResponse)
    {
        $rawResponseData = $connectorResponse->getRawResponseData();
        $responseCode = $connectorResponse->getResponseCode();

        try {
            $jsonObject = $this->jsonValidateAndDecode($rawResponseData);
        } catch (JsonException $ex) {
            throw new \Exception('Ulozenka API did not respond with valid JSON.');
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        if ($responseCode === 200) {
            $data = $this->proccessTransportServiceBranchesResponseData($this->getJsonAttr($jsonObject, ResponseAttr::DATA));
        } else {
            $data = [];
        }
        $errors = $this->proccessResponseErrors($jsonObject);
        $links = $this->proccessLinks($this->getJsonAttr($jsonObject, ResponseAttr::LINKS));

        $response = new GetTransportServiceBranchesResponse($rawResponseData, $responseCode, $links, $errors, $data);

        return $response;
    }

    /**
     *
     * @param ConnectorResponse $connectorResponse
     * @return GetStatusHistoryResponse
     */
    public function formatGetStatusHistoryResponse(ConnectorResponse $connectorResponse)
    {
        $rawResponseData = $connectorResponse->getRawResponseData();
        $responseCode = $connectorResponse->getResponseCode();

        try {
            $jsonObject = $this->jsonValidateAndDecode($rawResponseData);
        } catch (JsonException $ex) {
            throw new \Exception('Ulozenka API did not respond with valid JSON.');
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        if ($responseCode === 200) {
            $data = $this->proccessStatusHistoryResponseData($this->getJsonAttr($jsonObject, ResponseAttr::DATA));
        } else {
            $data = [];
        }
        $errors = $this->proccessResponseErrors($jsonObject);
        $links = $this->proccessLinks($this->getJsonAttr($jsonObject, ResponseAttr::LINKS));

        $response = new GetTransportServiceBranchesResponse($rawResponseData, $responseCode, $links, $errors, $data);

        return $response;
    }

    /**
     *
     * @param reference $parentNode
     * @param string $attributeName
     * @param mixed $value
     * @throws Exception
     */
    private function createAttributeIfHasValue(&$parentNode, $attributeName, $value)
    {
        if (isset($parentNode)) {
            if (!empty($value)) {
                $parentNode[$attributeName] = $value;
            }
        } else {
            throw new Exception('Parent node does not exist.');
        }
    }

    /**
     *
     * @param stdClass $jsonObject
     * @return Consignment[]
     */
    private function proccessConsignmentsResponseData($jsonObject)
    {
        $data = [];
        foreach ($this->getJsonAttr($jsonObject, ResponseAttr::DATA) as $dataObject) {
            $consignment = new Consignment();

            // receiver
            $receiver = new Receiver();
            $receiverAddress = new Address($this->getJsonAttr($dataObject, ConsignmentAttr::ADDRESS_STREET), $this->getJsonAttr($dataObject, ConsignmentAttr::ADDRESS_TOWN), $this->getJsonAttr($dataObject, ConsignmentAttr::ADDRESS_ZIP));
            $receiver->setName($this->getJsonAttr($dataObject, ConsignmentAttr::CUSTOMER_NAME))
                ->setSurname($this->getJsonAttr($dataObject, ConsignmentAttr::CUSTOMER_SURNAME))
                ->setCompany($this->getJsonAttr($dataObject, ConsignmentAttr::COMPANY_NAME))
                ->setAddress($receiverAddress)
                ->setPhone($this->getJsonAttr($dataObject, ConsignmentAttr::CUSTOMER_PHONE))
                ->setEmail($this->getJsonAttr($dataObject, ConsignmentAttr::CUSTOMER_EMAIL));
            $consignment->setReceiver($receiver);

            // other details
            $consignment->setId($this->getJsonAttr($dataObject, ConsignmentAttr::ID));
            $consignment->setShopId($this->getJsonAttr($dataObject, ConsignmentAttr::SHOP_ID));
            $consignment->setOrderNumber($this->getJsonAttr($dataObject, ConsignmentAttr::ORDER_NUMBER));
            $consignment->setParcelNumber($this->getJsonAttr($dataObject, ConsignmentAttr::PARCEL_NUMBER));
            $consignment->setDestinationCountry($this->getJsonAttr($dataObject, ConsignmentAttr::ADDRESS_STATE));
            $consignment->setPartnerConsignmentId($this->getJsonAttr($dataObject, ConsignmentAttr::PARTNER_CONSIGNMENT_ID));
            $consignment->setVariable($this->getJsonAttr($dataObject, ConsignmentAttr::VARIABLE));
            $consignment->setParcelCount($this->getJsonAttr($dataObject, ConsignmentAttr::PARCEL_COUNT));
            $consignment->setCashOnDelivery($this->getJsonAttr($dataObject, ConsignmentAttr::CASH_ON_DELIVERY));
            $consignment->setInsurance($this->getJsonAttr($dataObject, ConsignmentAttr::INSURANCE));
            $consignment->setStatedPrice($this->getJsonAttr($dataObject, ConsignmentAttr::STATED_PRICE));
            $consignment->setCurrency($this->getJsonAttr($dataObject, ConsignmentAttr::CURRENCY));
            $consignment->setRegisterBranchId($this->getJsonAttr($dataObject, ConsignmentAttr::REGISTER_BRANCH_ID));
            $consignment->setDestinationBranchId($this->getJsonAttr($dataObject, ConsignmentAttr::DESTINATION_BRANCH_ID));
            $consignment->setWeight($this->getJsonAttr($dataObject, ConsignmentAttr::WEIGHT) / 1000); // transform to kgs
            $consignment->setRequireFullAge($this->getJsonAttr($dataObject, ConsignmentAttr::REQUIRE_FULL_AGE));
            $consignment->setAllowCardPayment($this->getJsonAttr($dataObject, ConsignmentAttr::ALLOW_CARD_PAYMENT));
            $consignment->setPaidByCard($this->getJsonAttr($dataObject, ConsignmentAttr::CARD_PAID));
            $consignment->setNote($this->getJsonAttr($dataObject, ConsignmentAttr::NOTE));
            $consignment->setTransportServiceId($this->getJsonAttr($dataObject, ConsignmentAttr::TRANSPORT_SERVICE_ID));
            $consignment->setMaxStoringDateIncreasedByClient($this->getJsonAttr($dataObject, ConsignmentAttr::MAX_STORING_DATE_INCREASED_BY_CLIENT));
            $consignment->setMaxStoringDateIncreasedByPartner($this->getJsonAttr($dataObject, ConsignmentAttr::MAX_STORING_DATE_INCREASED_BY_PARTNER));

            // status
            $statusJsonAttr = $this->getJsonAttr($dataObject, ConsignmentAttr::STATUS);
            $consignment->setStatus(new CreateConsignmentStatus($this->getJsonAttr($statusJsonAttr, 'id'), $this->getJsonAttr($statusJsonAttr, 'name')));

            // datetime attributes
            $consignment->setTimeCreated($this->proccessDateTime($this->getJsonAttr($dataObject, ConsignmentAttr::TIME_CREATED)));
            $consignment->setTimeUpdated($this->proccessDateTime($this->getJsonAttr($dataObject, ConsignmentAttr::TIME_UPDATED)));
            $consignment->setTimeReceived($this->proccessDateTime($this->getJsonAttr($dataObject, ConsignmentAttr::TIME_RECEIVED)));
            $consignment->setTimeClosed($this->proccessDateTime($this->getJsonAttr($dataObject, ConsignmentAttr::TIME_CLOSED)));
            $consignment->setTimeCodSent($this->proccessDateTime($this->getJsonAttr($dataObject, ConsignmentAttr::TIME_COD_SENT)));
            $consignment->setTimeInvoiceSent($this->proccessDateTime($this->getJsonAttr($dataObject, ConsignmentAttr::TIME_INVOICE_SENT)));
            $consignment->setMaxStoringDate($this->proccessDateTime($this->getJsonAttr($dataObject, ConsignmentAttr::MAX_STORING_DATE)));

            // labels
            $consignment->setLabelsString($this->getJsonAttr($dataObject, ConsignmentAttr::LABELS));

            $data[] = $consignment;
        }
        return $data;
    }

    /**
     *
     * @param stdClass $dataObject
     * @return TransportServiceBranches
     */
    private function proccessTransportServiceBranchesResponseData($dataObject)
    {

        // REGISTER BRANCHES
        $register = [];
        $registerResponseJsonAttr = $this->getJsonAttr($dataObject, BranchAttr::RESPONSE_REGISTER);
        if (!empty($registerResponseJsonAttr)) {
            foreach ($registerResponseJson as $singleRegister) {
                // register branch specific information
                $rbDestinationsJsonAttr = $this->getJsonAttr($singleRegister, BranchAttr::RB_DESTINATIONS);
                if (!empty($rbDestinationsJsonAttr)) {
                    $registerDestinations = $this->proccessRegisterBranchDestinations($rbDestinationsJsonAttr);
                } else {
                    $registerDestinations = [];
                }

                $registerObject = new RegisterBranch($registerDestinations);

                // base branch information
                $registerLinks = $this->proccessLinks($this->getJsonAttr($singleRegister, BranchAttr::LINKS));
                $registerObject->setLinks($registerLinks);
                $registerObject->setId($this->getJsonAttr($singleRegister, BranchAttr::ID));
                $registerObject->setName($this->getJsonAttr($singleRegister, BranchAttr::NAME));
                $registerObject->setShortcut($this->getJsonAttr($singleRegister, BranchAttr::SHORTCUT));
                $registerObject->setStreet($this->getJsonAttr($singleRegister, BranchAttr::STREET));
                $registerObject->setHouseNumber($this->getJsonAttr($singleRegister, BranchAttr::HOUSE_NUMBER));
                $registerObject->setTown($this->getJsonAttr($singleRegister, BranchAttr::TOWN));
                $registerObject->setZip($this->getJsonAttr($singleRegister, BranchAttr::ZIP));
                $registerDistrictJsonAttr = $this->getJsonAttr($singleRegister, BranchAttr::DISTRICT);
                $districtObject = new District($this->getJsonAttr($registerDistrictJsonAttr, BranchAttr::DISTRICT_ID), $this->getJsonAttr($registerDistrictJsonAttr, BranchAttr::DISTRICT_NUTS_NUMBER), $this->getJsonAttr($registerDistrictJsonAttr, BranchAttr::DISTRICT_NAME));
                $registerObject->setDistrict($districtObject);
                $registerObject->setCountry($this->getJsonAttr($singleRegister, BranchAttr::COUNTRY));
                $registerObject->setPartner($this->getJsonAttr($singleRegister, BranchAttr::PARTNER));

                // branch information

                $registerObject->setEmail($this->getJsonAttr($singleRegister, BranchAttr::EMAIL));
                $registerObject->setPhone($this->getJsonAttr($singleRegister, BranchAttr::PHONE));
                $registerGpsJsonAttr = $this->getJsonAttr($singleRegister, BranchAttr::GPS);
                $gps = new Gps($this->getJsonAttr($registerGpsJsonAttr, BranchAttr::GPS_LATITUDE), $this->getJsonAttr($registerGpsJsonAttr, BranchAttr::GPS_LONGITUDE));
                $registerObject->setGps($gps);
                $navigation = new Navigation();
                $registerNavigationJsonAttr = $this->getJsonAttr($singleRegister, BranchAttr::NAVIGATION);
                $navigation->setGeneral($this->getJsonAttr($registerNavigationJsonAttr, BranchAttr::NAVIGATION_GENERAL));
                $navigation->setCar($this->getJsonAttr($registerNavigationJsonAttr, BranchAttr::NAVIGATION_CAR));
                $navigation->setPublicTransport($this->getJsonAttr($registerNavigationJsonAttr, BranchAttr::NAVIGATION_PUBLIC_TRANSPORT));
                $registerObject->setNavigation($navigation);
                $registerOpeningHoursJsonAttr = $this->getJsonAttr($singleRegister, BranchAttr::OPENING_HOURS);
                $regularOpeningHours = $this->getJsonAttr($registerOpeningHoursJsonAttr, BranchAttr::OPENING_HOURS_REGULAR);
                if (!empty($regularOpeningHours)) {
                    $regularOpeningHoursResult = $this->proccessRegularOpeningHours($regularOpeningHours);
                } else {
                    $regularOpeningHoursResult = null;
                }
                $openingHours = new OpeningHours($regularOpeningHoursResult, []);
                $registerObject->setOpeningHours($openingHours);
                $registerObject->setOtherInfo($this->getJsonAttr($singleRegister, BranchAttr::OTHER_INFO));
                $registerObject->setCardPaymentAccepted($this->getJsonAttr($singleRegister, BranchAttr::CARD_PAYMENT));

                // attach to the collection
                $register[] = $registerObject;
            }
        }

        // DESTINATION BRANCHES
        $destination = [];
        $responseDestinationJsonAttr = $this->getJsonAttr($dataObject, BranchAttr::RESPONSE_DESTINATION);
        if (!empty($responseDestinationJsonAttr)) {
            foreach ($responseDestinationJsonAttr as $singleDestination) {

                $destinationObject = new DestinationBranch();

                // specific information

                $destAllowedConsTypesJsonAttr = $this->getJsonAttr($singleDestination, BranchAttr::ALLOWED_CONSIGNMENT_TYPES);
                $allowedConsignmentTypesObject = new AllowedConsignmentTypes($this->getJsonAttr($destAllowedConsTypesJsonAttr, BranchAttr::ALLOWED_CONSIGNMENT_TYPES_STANDARD), $this->getJsonAttr($destAllowedConsTypesJsonAttr, BranchAttr::ALLOWED_CONSIGNMENT_TYPES_BACKWARD));
                $destinationObject->setAllowedConsignmentTypes($allowedConsignmentTypesObject);
                $destinationObject->setActive($this->getJsonAttr($singleDestination, BranchAttr::ACTIVE));
                $destinationObject->setPreparing($this->getJsonAttr($singleDestination, BranchAttr::PREPARING));
                $destinationAnnouncementsJsonAttr = $this->getJsonAttr($singleDestination, BranchAttr::DB_ANNOUNCEMENTS);
                if (!empty($destinationAnnouncementsJsonAttr)) {
                    $announcements = $this->proccessAnnouncements($destinationAnnouncementsJsonAttr);
                } else {
                    $announcements = [];
                }
                $destinationObject->setAnnouncements($announcements);

                // base branch information
                $destinationLinks = $this->proccessLinks($this->getJsonAttr($singleDestination, BranchAttr::LINKS));
                $destinationObject->setLinks($destinationLinks);
                $destinationObject->setId($this->getJsonAttr($singleDestination, BranchAttr::ID));
                $destinationObject->setName($this->getJsonAttr($singleDestination, BranchAttr::NAME));
                $destinationObject->setShortcut($this->getJsonAttr($singleDestination, BranchAttr::SHORTCUT));
                $destinationObject->setStreet($this->getJsonAttr($singleDestination, BranchAttr::STREET));
                $destinationObject->setHouseNumber($this->getJsonAttr($singleDestination, BranchAttr::HOUSE_NUMBER));
                $destinationObject->setTown($this->getJsonAttr($singleDestination, BranchAttr::TOWN));
                $destinationObject->setZip($this->getJsonAttr($singleDestination, BranchAttr::ZIP));
                $destinationDistrictJsonAttr = $this->getJsonAttr($singleDestination, BranchAttr::DISTRICT);
                $districtObject = new District($this->getJsonAttr($destinationDistrictJsonAttr, BranchAttr::DISTRICT_ID), $this->getJsonAttr($destinationDistrictJsonAttr, BranchAttr::DISTRICT_NUTS_NUMBER), $this->getJsonAttr($destinationDistrictJsonAttr, BranchAttr::DISTRICT_NAME));
                $destinationObject->setDistrict($districtObject);
                $destinationObject->setCountry($this->getJsonAttr($singleDestination, BranchAttr::COUNTRY));
                $destinationObject->setPartner($this->getJsonAttr($singleDestination, BranchAttr::PARTNER));

                // branch information

                $destinationObject->setEmail($this->getJsonAttr($singleDestination, BranchAttr::EMAIL));
                $destinationObject->setPhone($this->getJsonAttr($singleDestination, BranchAttr::PHONE));
                $destinationGpsJsonAttr = $this->getJsonAttr($singleDestination, BranchAttr::GPS);
                $gps = new Gps($this->getJsonAttr($destinationGpsJsonAttr, BranchAttr::GPS_LATITUDE), $this->getJsonAttr($destinationGpsJsonAttr, BranchAttr::GPS_LONGITUDE));
                $destinationObject->setGps($gps);
                $navigation = new Navigation();
                $destinationNavigationJsonAttr = $this->getJsonAttr($singleDestination, BranchAttr::NAVIGATION);
                $navigation->setGeneral($this->getJsonAttr($destinationNavigationJsonAttr, BranchAttr::NAVIGATION_GENERAL));
                $navigation->setCar($this->getJsonAttr($destinationNavigationJsonAttr, BranchAttr::NAVIGATION_CAR));
                $navigation->setPublicTransport($this->getJsonAttr($destinationNavigationJsonAttr, BranchAttr::NAVIGATION_PUBLIC_TRANSPORT));
                $destinationObject->setNavigation($navigation);
                $destinationOpeningHoursJsonAttr = $this->getJsonAttr($singleDestination, BranchAttr::OPENING_HOURS);
                $regularOpeningHours = $this->getJsonAttr($destinationOpeningHoursJsonAttr, BranchAttr::OPENING_HOURS_REGULAR);
                if (!empty($regularOpeningHours)) {
                    $regularOpeningHoursResult = $this->proccessRegularOpeningHours($regularOpeningHours);
                } else {
                    $regularOpeningHoursResult = null;
                }
                $openingHours = new OpeningHours($regularOpeningHoursResult, []);
                $destinationObject->setOpeningHours($openingHours);
                $destinationObject->setOtherInfo($this->getJsonAttr($singleDestination, BranchAttr::OTHER_INFO));
                $destinationObject->setCardPaymentAccepted($this->getJsonAttr($singleDestination, BranchAttr::CARD_PAYMENT));

                // attach to the collection
                $destination[] = $destinationObject;
            }
        }


        // CREATE FINAL OBJECT
        $tsBranches = new TransportServiceBranches($register, $destination);

        return $tsBranches;
    }

    /**
     *
     * @param stdClass $dataObject
     * @return ConsignmentStatus[]
     */
    private function proccessStatusHistoryResponseData($dataObject)
    {
        $statuses = [];
        if (!empty($dataObject)) {
            foreach ($dataObject as $singleStatus) {

                $consignmentJsonAttr = $this->getJsonAttr($singleStatus, 'consignment');
                $statusJsonAttr = $this->getJsonAttr($singleStatus, 'status');
                $datetimeJsonAttr = $this->getJsonAttr($singleStatus, 'datetime');

                $consignment = new StatusHistoryConsignment($this->proccessLinks($this->getJsonAttr($consignmentJsonAttr, '_links')), $this->getJsonAttr($consignmentJsonAttr, 'id'), $this->getJsonAttr($consignmentJsonAttr, 'partner_consignment_id'), $this->getJsonAttr($consignmentJsonAttr, 'order_number'));
                $status = new Status($this->getJsonAttr($statusJsonAttr, 'id'), $this->getJsonAttr($statusJsonAttr, 'name'));
                $datetime = $this->proccessDateTime($datetimeJsonAttr);
                $consignmentStatusObject = new ConsignmentStatus($consignment, $status, $datetime);

                // attach to the collection
                $statuses[] = $consignmentStatusObject;
            }
        }

        return $statuses;
    }

    /**
     *
     * @param stdClass $destinations
     * @return Destination[]
     */
    private function proccessRegisterBranchDestinations($destinations)
    {
        $registerDestinations = [];
        foreach ($destinations as $singleRegisterDestination) {
            $srdAllowedConsignmenttypesJsonAttr = $this->getJsonAttr($singleRegisterDestination, BranchAttr::ALLOWED_CONSIGNMENT_TYPES);
            $allowedConsignmentTypesObject = new AllowedConsignmentTypes($this->getJsonAttr($srdAllowedConsignmenttypesJsonAttr, BranchAttr::ALLOWED_CONSIGNMENT_TYPES_STANDARD), $this->getJsonAttr($srdAllowedConsignmenttypesJsonAttr, BranchAttr::ALLOWED_CONSIGNMENT_TYPES_BACKWARD));
            $registerDestinationObject = new Destination($this->getJsonAttr($singleRegisterDestination, BranchAttr::RB_DESTINATIONS_COUNTRY), $this->getJsonAttr($singleRegisterDestination, BranchAttr::ACTIVE), $this->getJsonAttr($singleRegisterDestination, BranchAttr::PREPARING), $allowedConsignmentTypesObject);
            $registerDestinations[] = $registerDestinationObject;
        }
        return $registerDestinations;
    }

    /**
     *
     * @param stdClass $regularOpeningHours
     * @return RegularOpeningHours
     */
    private function proccessRegularOpeningHours($regularOpeningHours)
    {
        $regularOpeningHoursObject = new RegularOpeningHours();
        foreach ($regularOpeningHours as $dayAlias => $dayArray) {
            $regularHoursJsonAttr = $this->getJsonAttr($dayArray, BranchAttr::OPENING_HOURS_REGULAR_HOURS);
            if (!empty($regularHoursJsonAttr)) {
                foreach ($regularHoursJsonAttr as $hours) {
                    $hoursObject = new Hours($this->getJsonAttr($hours, BranchAttr::OPENING_HOURS_REGULAR_HOURS_OPEN), $this->getJsonAttr($hours, BranchAttr::OPENING_HOURS_REGULAR_HOURS_CLOSE));
                    $regularOpeningHoursObject->addHours($dayAlias, $hoursObject);
                }
            }
        }
        return $regularOpeningHoursObject;
    }

    /**
     *
     * @param stdClass $announcements
     * @return Announcement[]
     */
    private function proccessAnnouncements($announcements)
    {
        $resultArray = [];
        foreach ($announcements as $singleAnnouncement) {
            $announcementObject = new Announcement($this->getJsonAttr($singleAnnouncement, BranchAttr::DB_ANNOUNCEMENTS_TEXT), $this->getJsonAttr($singleAnnouncement, BranchAttr::DB_ANNOUNCEMENTS_PRIORITY), $this->getJsonAttr($singleAnnouncement, BranchAttr::DB_ANNOUNCEMENTS_TITLE));
            $resultArray[] = $announcementObject;
        }
        return $resultArray;
    }

    /**
     *
     * @param DateTime|stdClass $timeObject
     */
    private function proccessDateTime($timeObject)
    {
        $dateTimeResult = null;
        if (isset($timeObject)) {
            if ($timeObject instanceof DateTime) {
                $dateTimeResult = $timeObject;
            } elseif ($timeObject instanceof \stdClass) {
                $timeZone = new DateTimeZone($this->getJsonAttr($timeObject, DateTimeAttr::TIMEZONE));
                $dateTimeResult = new DateTime($this->getJsonAttr($timeObject, DateTimeAttr::DATE), $timeZone);
            }
        }
        return $dateTimeResult;
    }

    /**
     *
     * @param stdClass $links
     * @return Link[]
     */
    private function proccessLinks($links)
    {
        // proccess HATEOAS links
        if (!empty($links)) {
            $linksArray = [];
            foreach ($links as $resourceName => $valueObj) {
                $singleLink = new Link($resourceName, $this->getJsonAttr($valueObj, LinkAttr::HREF));
                $linksArray[] = $singleLink;
            }
        } else {
            $linksArray = [];
        }

        return $linksArray;
    }

    /**
     *
     * @param stdClass $jsonObject
     * @return Error[]
     */
    private function proccessResponseErrors($jsonObject)
    {
        // proccess errors
        $errorsJsonAttr = $this->getJsonAttr($jsonObject, ResponseAttr::ERRORS);
        if (!empty($errorsJsonAttr)) {
            $errors = [];
            foreach ($errorsJsonAttr as $error) {
                $singleError = new Error($this->getJsonAttr($error, ErrorAttr::CODE), $this->getJsonAttr($error, ErrorAttr::DESCRIPTION));
                $errors[] = $singleError;
            }
        } else {
            $errors = [];
        }

        return $errors;
    }

    /**
     *
     * @param String $json
     * @param boolean $assocArray
     * @return array
     */
    private function jsonValidateAndDecode($json, $assocArray = false)
    {

        // decode the JSON data
        $result = json_decode($json, $assocArray);

        // switch and check possible JSON errors
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                break;
            case JSON_ERROR_DEPTH:
                throw new StackDepthException();
            case JSON_ERROR_STATE_MISMATCH:
                throw new StateMismatchException();
            case JSON_ERROR_CTRL_CHAR:
                throw new ControlCharacterException();
            case JSON_ERROR_SYNTAX:
                throw new SyntaxErrorException();
            case JSON_ERROR_UTF8:
                throw new MalformedUtf8Exception();
            default:
                throw new JsonException();
        }

        if ($result === "" || $result === null) {
            $m = 'Invalid, malformed or no JSON data received.';
            throw new JsonException($m);
        }

        // everything is OK
        return $result;
    }

    /**
     *
     * @param mixed $resource
     * @param string $attrName
     */
    private function getJsonAttr($resource, $attrName)
    {
        if (isset($resource) && isset($resource->$attrName)) {
            return $resource->$attrName;
        } else {
            return null;
        }
    }
}
