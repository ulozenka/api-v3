<?php

namespace UlozenkaLib\APIv3\Tests\Formatter;

use DateTime;
use Tester\Assert;
use Tester\TestCase;
use UlozenkaLib\APIv3\Formatter\JsonFormatter;
use UlozenkaLib\APIv3\Model\ConnectorResponse;

require __DIR__ . '/../bootstrap.php';

/**
 * TEST: JsonFormatterTest
 *
 * @author Petr Vácha <petr.vacha@ulozenka.cz>
 */
class JsonFormatterTest extends TestCase
{

    /** @var JsonFormatter */
    private $jsonFormatter;

    public function __construct()
    {
        $this->jsonFormatter = new JsonFormatter();
    }

    public function testFormatGetStatusHistoryResponseThrowsException()
    {
        $connectorResponse = new ConnectorResponse(200, 'Hello world!', []);
        Assert::exception(function() use ($connectorResponse) {
            $this->jsonFormatter->formatGetStatusHistoryResponse($connectorResponse);
        }, '\Exception', 'Ulozenka API did not respond with valid JSON.');
    }

    public function testFormatGetStatusHistoryResponseError()
    {
        $json = file_get_contents(__DIR__ . '/data/getStatusHistoryErrorResponse.json');
        $connectorResponse = new ConnectorResponse(401, $json, []);
        $getStatusHistoryResponse = $this->jsonFormatter->formatGetStatusHistoryResponse($connectorResponse);
        $code = $getStatusHistoryResponse->getResponseCode();
        $data = $getStatusHistoryResponse->getData();
        $errors = $getStatusHistoryResponse->getErrors();

        Assert::same(401, $code);
        Assert::same([], $data);
        Assert::count(1, $errors);
        Assert::same(1001, $errors[0]->getCode());
        Assert::same('X-Shop header missing. You have to send your shop id in the X-Shop http header of your request.', $errors[0]->getDescription());
    }

    public function testFormatGetStatusHistoryResponse()
    {
        $json = file_get_contents(__DIR__ . '/data/getStatusHistoryResponse.json');
        $connectorResponse = new ConnectorResponse(200, $json, []);
        $getStatusHistoryResponse = $this->jsonFormatter->formatGetStatusHistoryResponse($connectorResponse);
        $consignmentStatuses = $getStatusHistoryResponse->getData();
        $consignmentStatus = $consignmentStatuses[5];
        $consignment = $consignmentStatus->getConsignment();
        $status = $consignmentStatus->getStatus();
        $dateTime = $consignmentStatus->getDateTime();
        $conignmentLink = $consignment->getLinks()[0];
        $link = $getStatusHistoryResponse->getLinks()[0];
        $errors = $getStatusHistoryResponse->getErrors();

        Assert::same([], $errors);
        Assert::type('\UlozenkaLib\APIv3\Model\Link', $link);
        Assert::same('self', $link->getResourceName());
        Assert::same('https://api.ulozenka.cz/v3/statushistory?timeFrom=20151123232058', $link->getUrl());
        Assert::count(7, $consignmentStatuses);
        Assert::type('\UlozenkaLib\APIv3\Model\Link', $conignmentLink);
        Assert::same('self', $conignmentLink->getResourceName());
        Assert::same('https://api.ulozenka.cz/v3/consignments/3255848', $conignmentLink->getUrl());
        Assert::type('\UlozenkaLib\APIv3\Model\StatusHistory\ConsignmentStatus', $consignmentStatus);
        Assert::type('\UlozenkaLib\APIv3\Model\StatusHistory\Consignment', $consignment);
        Assert::same(3255848, $consignment->getId());
        Assert::same('051580000012', $consignment->getPartnerConsignmentId());
        Assert::same('test_pns_1006', $consignment->getOrderNumber());
        Assert::type('\UlozenkaLib\APIv3\Model\StatusHistory\Status', $status);
        Assert::same(4, $status->getId());
        Assert::same('připraveno k výdeji', $status->getName());
        Assert::equal(new DateTime('2015-11-24 16:50:05 Europe/Prague'), $dateTime);
    }

    public function testFormatCreateConsignmentResponseThrowsException()
    {
        $connectorResponse = new ConnectorResponse(200, 'Hello world!', []);
        Assert::exception(function() use ($connectorResponse) {
            $this->jsonFormatter->formatCreateConsignmentResponse($connectorResponse);
        }, '\Exception', 'Ulozenka API did not respond with valid JSON.');
    }

    public function testFormatCreateConsignmentResponseError()
    {
        $json = file_get_contents(__DIR__ . '/data/createConsignmentErrorResponse.json');
        $connectorResponse = new ConnectorResponse(400, $json, []);
        $getStatusHistoryResponse = $this->jsonFormatter->formatGetStatusHistoryResponse($connectorResponse);
        $code = $getStatusHistoryResponse->getResponseCode();
        $data = $getStatusHistoryResponse->getData();
        $errors = $getStatusHistoryResponse->getErrors();

        Assert::same(400, $code);
        Assert::same([], $data);
        Assert::count(1, $errors);
        Assert::same(4002, $errors[0]->getCode());
        Assert::same('Given currency (CZ) not found.', $errors[0]->getDescription());
    }

    public function testFormatCreateConsignmentResponse()
    {
        $json = file_get_contents(__DIR__ . '/data/createConsignmentResponse.json');
        $connectorResponse = new ConnectorResponse(200, $json, []);
        $createConsignmentResponse = $this->jsonFormatter->formatCreateConsignmentResponse($connectorResponse);
        $data = $createConsignmentResponse->getData();
        $consignment = $createConsignmentResponse->getConsignment();
        $link = $createConsignmentResponse->getLinks()[0];
        $errors = $createConsignmentResponse->getErrors();

        Assert::same([], $errors);
        Assert::count(1, $data);
        Assert::type('\UlozenkaLib\APIv3\Model\Link', $link);
        Assert::same('self', $link->getResourceName());
        Assert::same('https://api.ulozenka.local/v3/consignments/3049048', $link->getUrl());
        Assert::type('\UlozenkaLib\APIv3\Model\Consignment\Response\Consignment', $consignment);
        Assert::same(3049048, $consignment->getId());
        Assert::same(5158, $consignment->getShopId());
        Assert::type('\UlozenkaLib\APIv3\Model\Consignment\Receiver', $consignment->getReceiver());
        Assert::same('John', $consignment->getReceiver()->getName());
        Assert::same('Doe', $consignment->getReceiver()->getSurname());
        Assert::same(null, $consignment->getReceiver()->getCompany());
        Assert::type('\UlozenkaLib\APIv3\Model\Consignment\Address', $consignment->getReceiver()->getAddress());
        Assert::same(null, $consignment->getReceiver()->getAddress()->getStreet());
        Assert::same(null, $consignment->getReceiver()->getAddress()->getTown());
        Assert::same(null, $consignment->getReceiver()->getAddress()->getZip());
        Assert::same('CZE', $consignment->getDestinationCountry());
        Assert::same('+420602602602', $consignment->getReceiver()->getPhone());
        Assert::same('foo@ulozenka.cz', $consignment->getReceiver()->getEmail());
        Assert::same('123123', $consignment->getOrderNumber());
        Assert::same(null, $consignment->getPartnerConsignmentId());
        Assert::same(null, $consignment->getVariable());
        Assert::same(2, $consignment->getParcelCount());
        Assert::same(200, $consignment->getCashOnDelivery());
        Assert::same(null, $consignment->getInsurance());
        Assert::same(null, $consignment->getStatedPrice());
        Assert::same('CZK', $consignment->getCurrency());
        Assert::same(14, $consignment->getRegisterBranchId());
        Assert::same(1, $consignment->getDestinationBranchId());
        Assert::equal(new DateTime('2015-11-29 12:59:20 Europe/Prague'), $consignment->getTimeCreated());
        Assert::equal(new DateTime('2015-11-29 12:59:20 Europe/Prague'), $consignment->getTimeReceived());
        Assert::same(null, $consignment->getMaxStoringDate());
        Assert::same(null, $consignment->getTimeClosed());
        Assert::type('\UlozenkaLib\APIv3\Model\Consignment\Status', $consignment->getStatus());
        Assert::same(1, $consignment->getStatus()->getId());
        Assert::same('čekáme na doručení', $consignment->getStatus()->getName());
        Assert::same(null, $consignment->getParcelNumber());
        Assert::same(3.21, $consignment->getWeight());
        Assert::same(false, $consignment->getRequireFullAge());
        Assert::same(true, $consignment->getAllowCardPayment());
        Assert::same(false, $consignment->getPaidByCard());
        Assert::same(null, $consignment->getNote());
        Assert::equal(new DateTime('2015-11-29 12:59:21 Europe/Prague'), $consignment->getTimeUpdated());
        Assert::same(null, $consignment->getTimeCodSent());
        Assert::same(null, $consignment->getTimeInvoiceSent());
        Assert::same(1, $consignment->getTransportServiceId());
        Assert::same(false, $consignment->getMaxStoringDateIncreasedByClient());
        Assert::same(false, $consignment->getMaxStoringDateIncreasedByPartner());
    }

    public function testFormatGetTransportServiceBranchesResponseThrowsException()
    {
        $connectorResponse = new ConnectorResponse(200, 'Hello world!', []);
        Assert::exception(function() use ($connectorResponse) {
            $this->jsonFormatter->formatGetTransportServiceBranchesResponse($connectorResponse);
        }, '\Exception', 'Ulozenka API did not respond with valid JSON.');
    }

    public function testFormatGetTransportServiceBranchesResponseError()
    {
        $json = file_get_contents(__DIR__ . '/data/getTransportServiceBranchesErrorResponse.json');
        $connectorResponse = new ConnectorResponse(404, $json, []);
        $getTransportServiceBranchesResponse = $this->jsonFormatter->formatGetTransportServiceBranchesResponse($connectorResponse);
        $code = $getTransportServiceBranchesResponse->getResponseCode();
        $link = $getTransportServiceBranchesResponse->getLinks()[0];
        $data = $getTransportServiceBranchesResponse->getData();
        $errors = $getTransportServiceBranchesResponse->getErrors();

        Assert::same(404, $code);
        Assert::same('self', $link->getResourceName());
        Assert::same('https://api.ulozenka.local/v3/transportservices/44/branches', $link->getUrl());
        Assert::same([], $data);
        Assert::count(1, $errors);
        Assert::same(5003, $errors[0]->getCode());
        Assert::same('Requested transport service not found', $errors[0]->getDescription());
    }

    public function testFormatGetTransportServiceBranchesResponse()
    {
        $json = file_get_contents(__DIR__ . '/data/getTransportServiceBranchesResponse.json');
        $connectorResponse = new ConnectorResponse(200, $json, []);
        $getTransportServiceBranchesResponse = $this->jsonFormatter->formatGetTransportServiceBranchesResponse($connectorResponse);
        $code = $getTransportServiceBranchesResponse->getResponseCode();
        $link = $getTransportServiceBranchesResponse->getLinks()[0];
        $errors = $getTransportServiceBranchesResponse->getErrors();
        $registerBranches = $getTransportServiceBranchesResponse->getRegisterBranches();
        $secondRegisterBranch = $registerBranches[1];
        $destinationBranches = $getTransportServiceBranchesResponse->getDestinationBranches();

        // response code
        Assert::same(200, $code);

        // links
        Assert::type('\UlozenkaLib\APIv3\Model\Link', $link);
        Assert::same('self', $link->getResourceName());
        Assert::same('https://api.ulozenka.local/v3/transportservices/1/branches?shopId=5158&destinationOnly=0&registerOnly=0&includeInactive=1', $link->getUrl());

        // errors
        Assert::same([], $errors);

        // register branches
        Assert::count(2, $registerBranches);
        Assert::type('\UlozenkaLib\APIv3\Model\TransportService\Branch\RegisterBranch', $secondRegisterBranch);
        $branchLinks = $secondRegisterBranch->getLinks();
        Assert::count(3, $branchLinks);
        $websiteLink = $branchLinks[0];
        $pictureLink = $branchLinks[1];
        $selfLink = $branchLinks[2];
        Assert::same('website', $websiteLink->getResourceName());
        Assert::same('https://www.ulozenka.cz/pobocky/3/ostrava-28-rijna-1422-299', $websiteLink->getUrl());
        Assert::same('picture', $pictureLink->getResourceName());
        Assert::same('https://www.ulozenka.cz/cdn/images/branches/register/3.png', $pictureLink->getUrl());
        Assert::same('self', $selfLink->getResourceName());
        Assert::same('https://api.ulozenka.local/v3/branches/3', $selfLink->getUrl());
        Assert::same(3, $secondRegisterBranch->getId());
        Assert::same('ostra', $secondRegisterBranch->getShortcut());
        Assert::same('Ostrava, 28.října 1422/299', $secondRegisterBranch->getName());
        $destinations = $secondRegisterBranch->getDestinations();
        Assert::count(2, $destinations);
        $destination = $destinations[1];
        Assert::same('SVK', $destination->getCountry());
        Assert::same(true, $destination->getActive());
        Assert::same(false, $destination->getPreparing());
        Assert::same(true, $destination->getAllowedConsignmentTypes()->getStandardConsignment());
        Assert::same(false, $destination->getAllowedConsignmentTypes()->getBackwardConsignment());
        Assert::same('+420777208204', $secondRegisterBranch->getPhone());
        Assert::same('info@ulozenka.cz', $secondRegisterBranch->getEmail());
        Assert::same('28.října', $secondRegisterBranch->getStreet());
        Assert::same('1422/299', $secondRegisterBranch->getHouseNumber());
        Assert::same('Ostrava - Mariánské Hory a Hulváky', $secondRegisterBranch->getTown());
        Assert::same('70900', $secondRegisterBranch->getZip());
        $district = $secondRegisterBranch->getDistrict();
        Assert::same(14, $district->getId());
        Assert::same('CZ080', $district->getNutsNumber());
        Assert::same('Moravskoslezský kraj', $district->getName());
        Assert::same('CZE', $secondRegisterBranch->getCountry());
        $openingHours = $secondRegisterBranch->getOpeningHours();
        $regularOpeningHours = $openingHours->getRegular();
        $monday = $regularOpeningHours->getMonday();
        Assert::count(2, $monday);
        Assert::same('11:00', $monday[0]->getOpen());
        Assert::same('12:00', $monday[0]->getClose());
        Assert::same('13:00', $monday[1]->getOpen());
        Assert::same('19:00', $monday[1]->getClose());
        $tuesday = $regularOpeningHours->getTuesday();
        Assert::count(1, $tuesday);
        Assert::same('11:00', $tuesday[0]->getOpen());
        Assert::same('19:00', $tuesday[0]->getClose());
        $saturday = $regularOpeningHours->getSaturday();
        Assert::same([], $saturday);
        $exceptionOpeningHours = $openingHours->getExceptions();
        Assert::same([], $exceptionOpeningHours);
        $gps = $secondRegisterBranch->getGps();
        Assert::same(49.82552, $gps->getLatitude());
        Assert::same(18.242718, $gps->getLongitude());
        $navigation = $secondRegisterBranch->getNavigation();
        Assert::same('general navigation', $navigation->getGeneral());
        Assert::same('car navigation', $navigation->getCar());
        Assert::same('public transport navigation', $navigation->getPublicTransport());
        Assert::same('other info', $secondRegisterBranch->getOtherInfo());
        Assert::same(true, $secondRegisterBranch->getCardPaymentAccepted());
        Assert::same(false, $secondRegisterBranch->getPartner());

        // destination branches
        Assert::count(4, $destinationBranches);
        $firstDestinationBranch = $destinationBranches[0];
        Assert::type('\UlozenkaLib\APIv3\Model\TransportService\Branch\DestinationBranch', $firstDestinationBranch);
        $branchLinks = $firstDestinationBranch->getLinks();
        Assert::count(3, $branchLinks);
        $websiteLink = $branchLinks[0];
        $pictureLink = $branchLinks[1];
        $selfLink = $branchLinks[2];
        Assert::same('website', $websiteLink->getResourceName());
        Assert::same('https://www.ulozenka.cz/pobocky/6/brno-cernopolni-54-245', $websiteLink->getUrl());
        Assert::same('picture', $pictureLink->getResourceName());
        Assert::same('https://www.ulozenka.cz/cdn/images/branches/destination/6.png', $pictureLink->getUrl());
        Assert::same('self', $selfLink->getResourceName());
        Assert::same('https://api.ulozenka.local/v3/branches/6', $selfLink->getUrl());
        Assert::same(6, $firstDestinationBranch->getId());
        Assert::same('brno2', $firstDestinationBranch->getShortcut());
        Assert::same('Brno, Černopolní 54/245', $firstDestinationBranch->getName());
        Assert::same(true, $firstDestinationBranch->getAllowedConsignmentTypes()->getStandardConsignment());
        Assert::same(true, $firstDestinationBranch->getAllowedConsignmentTypes()->getBackwardConsignment());
        Assert::same('+420777208204', $firstDestinationBranch->getPhone());
        Assert::same('info@ulozenka.cz', $firstDestinationBranch->getEmail());
        Assert::same('Černopolní', $firstDestinationBranch->getStreet());
        Assert::same('54/245', $firstDestinationBranch->getHouseNumber());
        Assert::same('Brno - Černá Pole', $firstDestinationBranch->getTown());
        Assert::same('61300', $firstDestinationBranch->getZip());
        $district = $firstDestinationBranch->getDistrict();
        Assert::same(11, $district->getId());
        Assert::same('CZ064', $district->getNutsNumber());
        Assert::same('Jihomoravský kraj', $district->getName());
        Assert::same('CZE', $firstDestinationBranch->getCountry());
        $openingHours = $firstDestinationBranch->getOpeningHours();
        $regularOpeningHours = $openingHours->getRegular();
        $monday = $regularOpeningHours->getMonday();
        Assert::count(1, $monday);
        Assert::same('11:00', $monday[0]->getOpen());
        Assert::same('19:00', $monday[0]->getClose());
        $tuesday = $regularOpeningHours->getTuesday();
        Assert::count(1, $tuesday);
        Assert::same('11:00', $tuesday[0]->getOpen());
        Assert::same('19:00', $tuesday[0]->getClose());
        $saturday = $regularOpeningHours->getSaturday();
        Assert::same([], $saturday);
        $exceptionOpeningHours = $openingHours->getExceptions();
        Assert::same([], $exceptionOpeningHours);
        $gps = $firstDestinationBranch->getGps();
        Assert::same(49.208607, $gps->getLatitude());
        Assert::same(16.614868, $gps->getLongitude());
        $navigation = $firstDestinationBranch->getNavigation();
        Assert::same('general navigation', $navigation->getGeneral());
        Assert::same('car navigation', $navigation->getCar());
        Assert::same('public transport navigation', $navigation->getPublicTransport());
        Assert::same('other info', $firstDestinationBranch->getOtherInfo());
        Assert::same(true, $firstDestinationBranch->getCardPaymentAccepted());
        Assert::same(false, $firstDestinationBranch->getPartner());
        $announcements = $firstDestinationBranch->getAnnouncements();
        Assert::count(2, $announcements);
        Assert::same('Změna otevírací doby', $announcements[0]->getTitle());
        Assert::same('V pátek bude otevřeno až do půlnoci', $announcements[0]->getText());
        Assert::same(12, $announcements[0]->getPriority());
        Assert::same('Havárie vody', $announcements[1]->getTitle());
        Assert::same('Z důvodu havárie vody bude pobočka uzavřena', $announcements[1]->getText());
        Assert::same(4, $announcements[1]->getPriority());

        Assert::same(false, $destinationBranches[3]->getActive());
        Assert::same('SVK', $destinationBranches[2]->getCountry());
        Assert::same(false, $destinationBranches[2]->getCardPaymentAccepted());
        Assert::same([], $destinationBranches[2]->getAnnouncements());
        Assert::same(true, $destinationBranches[1]->getPreparing());
    }

    public function testFormatCreateConsignmentRequest()
    {
        $address = new \UlozenkaLib\APIv3\Model\Consignment\Address('U průhonu 21/3a', 'Praha', '14000');
        $receiver = new \UlozenkaLib\APIv3\Model\Consignment\Receiver();
        $receiver->setName('Jan')
            ->setSurname('Nový')
            ->setCompany('Společnost s.r.o.')
            ->setEmail('jan@novy.cz')
            ->setPhone('+420777208204')
            ->setAddress($address);
        $request = new \UlozenkaLib\APIv3\Resource\Consignments\Request\ConsignmentRequest($receiver, 'order_001', 2, 11);
        $request->setCashOnDelivery(12.3)
            ->setCurrency('CZK')
            ->setInsurance(500)
            ->setStatedPrice(200)
            ->setNote('Neklopit')
            ->setAllowCardPayment(true)
            ->setRequireFullAge(true)
            ->setDestinationCountry('CZE')
            ->setDestinationBranchId(50001)
            ->setRegisterBranchId(7)
            ->setWeight(21.3)
            ->setVariable(123321)
            ->setPartnerConsignmentId('051580000001');
        $request->requireLabel(\UlozenkaLib\APIv3\Enum\Attributes\LabelAttr::TYPE_PDF, 2, 4, true);
        $parcel1 = new \UlozenkaLib\APIv3\Model\Consignment\Parcel('10001');
        $parcel2 = new \UlozenkaLib\APIv3\Model\Consignment\Parcel('10002');
        $request->setParcels([$parcel1, $parcel2]);

        $jsonStringRequest = $this->jsonFormatter->formatCreateConsignmentRequest($request);
        $expectedJsonString = file_get_contents(__DIR__ . '/data/createConsignmentRequest.json');
        Assert::same($expectedJsonString, $jsonStringRequest);

        $address = new \UlozenkaLib\APIv3\Model\Consignment\Address('U průhonu', 'Praha', '14000', '21/3a');
        $receiver->setAddress($address);
        $jsonStringRequest = $this->jsonFormatter->formatCreateConsignmentRequest($request);
        Assert::same($expectedJsonString, $jsonStringRequest);

        $address = new \UlozenkaLib\APIv3\Model\Consignment\Address('U průhonu', 'Praha', '14000', '21', '3a');
        $receiver->setAddress($address);
        $jsonStringRequest = $this->jsonFormatter->formatCreateConsignmentRequest($request);
        Assert::same($expectedJsonString, $jsonStringRequest);
    }
}

$test = new JsonFormatterTest();
$test->run();
