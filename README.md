Uloženka APIv3 library
=========================

[![Build Status](https://travis-ci.org/ulozenka/api-v3.svg?branch=master)](https://travis-ci.org/ulozenka/api-v3) 
[![Latest Stable Version](https://poser.pugx.org/ulozenka/api-v3/v/stable)](https://packagist.org/packages/ulozenka/api-v3) [![Total Downloads](https://poser.pugx.org/ulozenka/api-v3/downloads)](https://packagist.org/packages/ulozenka/api-v3)  [![License](https://poser.pugx.org/ulozenka/api-v3/license)](https://packagist.org/packages/ulozenka/api-v3)

Requirements
-------------

- PHP 5.4 or higher
- [bitbang/http](https://packagist.org/packages/bitbang/http)


Installation
-------------

:information_source: Examples below relates to the dev-master.

Install ulozenka/api-v3 using  [Composer](http://getcomposer.org/)
```sh
$ composer require ulozenka/api-v3:dev-master
```


Usage
-------------

###Create consignment

```php
$endpoint = \UlozenkaLib\APIv3\Enum\Endpoint::PRODUCTION;
$shopId = 5158;
$apiKey = 'my_secret_api_key_i_have_generated_in_my_ulozenka_shop_settings';

$api = new \UlozenkaLib\APIv3\Api($endpoint, $shopId, $apiKey);

// create receiver of the consignment
$receiver = new UlozenkaLib\APIv3\Model\Consignment\Receiver();
$receiver->setName('John');
$receiver->setSurname('Doe');
$receiver->setPhone('+420602602602');
$receiver->setEmail('foo@ulozenka.cz');

// my consignment identification
$orderNumber = "123123";

// parcel count
$parcelCount = 2;

// transport service to be used
$transportServiceId = \UlozenkaLib\APIv3\Enum\TransportService::ULOZENKA;

// create a consignment request
$consignmentRequest = new UlozenkaLib\APIv3\Resource\Consignments\Request\ConsignmentRequest($receiver, $orderNumber, $parcelCount, $transportServiceId);
$consignmentRequest->setDestinationBranchId(1);
$consignmentRequest->setCashOnDelivery(200);
$consignmentRequest->setCurrency('CZK');
$consignmentRequest->setWeight(3.21);

// send the request and process the response
$createConsignmentResponse = $api->createConsignment($consignmentRequest);
if ($createConsignmentResponse->isSuccess()) {
    var_dump($createConsignmentResponse->getConsignment());
} else {
    $errors = $createConsignmentResponse->getErrors();
    foreach ($errors as $error) {
        echo $error->getCode() . ' ' . $error->getDescription() . PHP_EOL;
    }
}
```

###Get destination branches for transport service
```php
$endpoint = \UlozenkaLib\APIv3\Enum\Endpoint::PRODUCTION;
$shopId = 5158;

$api = new \UlozenkaLib\APIv3\Api($endpoint);

$transportServiceId = \UlozenkaLib\APIv3\Enum\TransportService::ULOZENKA;

// get the destination branches for transport service Ulozenka with respect to settings of the shop with id $shopId
$getTransportServiceBranchesResponse = $api->getTransportServiceBranches($transportServiceId, $shopId, true);

// process the response
if ($getTransportServiceBranchesResponse->isSuccess()) {
    foreach ($getTransportServiceBranchesResponse->getDestinationBranches() as $branch) {
        echo $branch->getId() . ' ' . $branch->getName() . PHP_EOL;
    }
} else {
    $errors = $getTransportServiceBranchesResponse->getErrors();
    foreach ($errors as $error) {
        echo $error->getCode() . ' ' . $error->getDescription() . PHP_EOL;
    }
}
```

###Get labels for consignments
```php
$endpoint = \UlozenkaLib\APIv3\Enum\Endpoint::PRODUCTION;
$shopId = 5158;
$apiKey = 'my_secret_api_key_i_have_generated_in_my_ulozenka_shop_settings';

$api = new \UlozenkaLib\APIv3\Api($endpoint, $shopId, $apiKey);

// array of consignment id or partner_consignment_id values
$consignments = [2701036, 2779198, "051580033333"];

// send the request
$labelsResponse = $api->getLabels($consignments, \UlozenkaLib\APIv3\Enum\Attributes\LabelAttr::TYPE_PDF, $firstPosition = 1, $labelsPerPage = 1, $shopId, $apiKey);

// process the response
if ($labelsResponse->isSuccess()) {
	$pdf = fopen ('out.pdf','w');
	fwrite ($pdf, $labelsResponse->getLabelsString());
	fclose ($pdf);   
} else {
    $errors = $labelsResponse->getErrors();
    foreach ($errors as $error) {
        echo $error->getCode() . ' ' . $error->getDescription() . PHP_EOL;
    }
}
```

###Status history
```php
$shopId = 5158;
$apiKey = 'my_secret_api_key_i_have_generated_in_my_ulozenka_shop_settings';

$api = new \UlozenkaLib\APIv3\Api();

$dateLimit = new DateTime('YESTERDAY');

// get statuses that has been published since yesterday's midnight
$statusHistoryResponse = $api->getStatusHistory(null, $dateLimit, $shopId, $apiKey);

// process the response
if ($statusHistoryResponse->isSuccess()) {
    foreach ($statusHistoryResponse->getData() as $consignmentStatus) {
        echo 'Consignment id: ' . $consignmentStatus->getConsignment()->getId() . PHP_EOL;
        echo 'Status time: ' . $consignmentStatus->getDateTime()->format('Y-m-d H:i:s') . PHP_EOL;
        echo 'Status name: ' . $consignmentStatus->getStatus()->getName() . PHP_EOL . PHP_EOL;
    }
} else {
    $errors = $statusHistoryResponse->getErrors();
    foreach ($errors as $error) {
        echo $error->getCode() . ' ' . $error->getDescription() . PHP_EOL;
    }
}
```

###Tracking
```php
$api = new \UlozenkaLib\APIv3\Api();

$consignment = 444000;

$trackingResponse = $api->getTracking($consignment);

// process the response
if ($trackingResponse->isSuccess()) {
    echo 'Consignment id: ' . $trackingResponse->getConsignment()->getId() . PHP_EOL;
    echo 'Transport service: ' . $trackingResponse->getTransportService()->getName() . PHP_EOL;
    foreach ($trackingResponse->getStatuses() as $status) {
        echo $status->getDate()->format('Y-m-d H:i:s') . ' ' . $status->getName() . PHP_EOL;
    }
} else {
    $errors = $trackingResponse->getErrors();
    foreach ($errors as $error) {
        echo $error->getCode() . ' ' . $error->getDescription() . PHP_EOL;
    }
}
```