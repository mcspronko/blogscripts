#!/usr/bin/env php
<?php

try {
    require __DIR__ . '/app/bootstrap.php';
} catch (\Exception $e) {
    echo 'Autoload error: ' . $e->getMessage();
    exit(1);
}

$config = array(
    'adapter'   => 'Zend\Http\Client\Adapter\Curl',
    'curloptions' => array(CURLOPT_FOLLOWLOCATION => true),
    'maxredirects' => 0,
    'timeout' => 30
);
$client = new Zend\Http\Client(null, $config);
$request = new \Zend\Http\Request();
$httpHeaders = new \Zend\Http\Headers();
$httpHeaders->addHeaders([
    'Content-Type' => 'application/json'
]);
$request->setHeaders($httpHeaders);
$request->setUri('http://mrealex.dev/index.php/rest/V1/integration/admin/token');
$request->setMethod(\Zend_Http_Client::POST);
$params = new \Zend\Stdlib\Parameters([
    'username' => 'admin',
    'password' => '123123q'
]);
$request->setQuery($params);

$response = $client->send($request);

$token = $response->getContent();
var_dump('Token: ' . $token);
$request = new \Zend\Http\Request();
$httpHeaders->addHeaders([
    'Authorization' => 'Bearer ' . $token,
    'Accept' => 'application/json',
    'Content-Type' => 'application/json'
]);
$request->setHeaders($httpHeaders);
$request->setUri('http://mrealex.dev/index.php/rest/V1/customers/search');
$request->setMethod(\Zend_Http_Client::GET);
$params = new \Zend\Stdlib\Parameters([
    'searchCriteria' => '*'
]);
$request->setQuery($params);

$response = $client->send($request);

print_r($response->getContent());
