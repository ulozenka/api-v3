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
}

$test = new JsonFormatterTest();
$test->run();
