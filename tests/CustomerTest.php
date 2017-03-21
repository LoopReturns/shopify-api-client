<?php
	require_once ( 'vendor/autoload.php');

	$sc = new \RocketCode\Shopify\Client;

	$cHandle = $sc::Customer();
	$cHandle->setApiKey('58a81ddf6c0242f98e088b717fda5c68');
        $cHandle->setDomain('santucci.myshopify.com');
        $cHandle->setApiPass('986b4483dd02b1f12875f232ebeb678f');
	$cHandle->_makeUrl();

	$customer = $cHandle->search([ 'query' => 'email:santucci3@rocketcode.io'] );

	print json_encode( $customer ) . "\n";
