#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

$url = 'http://magento.dev/';
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
$request->setUri($url . 'rest/V1/integration/admin/token');
$request->setMethod(\Zend\Http\Request::METHOD_POST);
$params = new \Zend\Stdlib\Parameters([
    'username' => 'apiuser',
    'password' => '123123q'
]);
$request->setQuery($params);

$response = $client->send($request);

$token = json_decode($response->getContent());
var_dump('Token: ' . $token);
$request = new \Zend\Http\Request();
$httpHeaders->addHeaders([
    'Authorization' => 'Bearer ' . $token,
    'Accept' => 'application/json',
    'Content-Type' => 'application/json'
]);
$request->setHeaders($httpHeaders);
$request->setUri($url . 'rest/V1/customers/search');
$request->setMethod(\Zend\Http\Request::METHOD_GET);
$params = new \Zend\Stdlib\Parameters([
    'searchCriteria' => '*'
]);
$request->setQuery($params);

$response = $client->send($request);

print_r($response->getContent());
