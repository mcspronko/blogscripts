#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Laminas\Http\Client;
use Laminas\Http\Headers;
use Laminas\Http\Request;
use Laminas\Stdlib\Parameters;

$url = 'https://magento.test/';
$tokenEndpoint = 'rest/V1/integration/admin/token';

$client = new Client();
$client->setOptions([
    'maxredirects' => 0,
    'timeout' => 30
]);
$request = new Request();
$request->setUri($url . $tokenEndpoint);
$request->setMethod('POST');
$headers = new Headers();
$headers->addHeaders([
    'Content-Type' => 'application/json',
]);
$request->setHeaders($headers);
$params = new Parameters();
$params->set('username', 'admin-name');
$params->set('password', 'admin-password');
$request->setQuery($params);

//$response = $client->send($request);

//var_dump('Token: ' . $response->getContent());

// Access Token from the Admin -> System -> Integrations page.
$token = '992mlrl5qzd3wqz0mhnkfhrsey98of6v';

$headers = new Headers();
$headers->addHeaders([
    'Authorization' => 'Bearer ' . $token,
    'Accept' => 'application/json',
    'Content-Type' => 'application/json',
]);

$request->setHeaders($headers);
$request->setUri($url . 'rest/V1/customers/search');
$request->setMethod('GET');
$params = new Parameters([
    'searchCriteria' => '*'
]);
$request->setQuery($params);

$response = $client->send($request);

$result = json_decode($response->getBody(), true);
$customer = array_shift($result['items']);

var_dump($customer['firstname'] . ' ' . $customer['lastname']);
