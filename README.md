Uloženka APIv3 library
=========================

Requirements
-------------

- PHP 5.4 or higher
- [bitbang/http](https://packagist.org/packages/bitbang/http)


Installation
-------------

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

// create receiver of the consignemnt
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
$consignmentRequest = new UlozenkaLib\APIv3\Model\Consignment\Request\ConsignmentRequest($receiver, $orderNumber, $parcelCount, $transportServiceId);
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