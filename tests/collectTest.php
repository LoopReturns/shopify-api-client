<?php

require_once 'vendor/autoload.php';

putenv('SHOP_API_KEY=57ce0f2a615c348e7e703f8e44f010e8');
putenv('SHOP_API_PASSWORD=0f27e5fc5c0d9341b545e4f3b22d5d0f');
putenv('SHOP_DOMAIN=brandon-development-store.myshopify.com');

$sc = new Xariable\Shopify\Client;

$obj = $sc::Collect();

print "Class of ( obj ) : " . get_class( $obj );
print "\n";

$product_id = "2097873795";
$collection_id = "157528323";
$collect_id = "17846999363";

$result = $obj->all();
print ( $result );
print "\n";

$result = $obj->all(array( 'filters' => array(
	'limit' => 1,
)));
print( $result );
print "\n";

$result = $obj->all( array( 'filters' => array(
	'collection_id' => $collection_id
)));
print( $result );
print "\n";

$result = $obj->all( array( 'filters' => array(
	'product_id' => $product_id
)));
print( $result );
print "\n";


$result = $obj->count();
print ( $result );
print "\n";

$result = $obj->count( array( 'filters' => array(
	'collection_id' => $collection_id
)));
print( $result );
print "\n";

$result = $obj->count( array( 'filters' => array(
	'product_id' => $product_id
)));
print( $result );
print "\n";

################################################

$result = $obj->all(array( 'filters' => array(
	'limit' => 1,
)));
$resultArray = json_decode( $result );
$resultObj = $resultArray[0];
var_dump( $resultObj );

$result = $obj->find( array( 'id' => strval( $resultObj->id ) ) );
print ( $result );
print "\n";

$result = $obj->delete( array( 'id' => strval( $resultObj->id ) ) );
print ( $result );
print "\n";

$ct = array(
	'collection_id' => strval( $resultObj->collection_id ),
	'product_id' => strval( $resultObj->product_id ),
);
$result = $obj->create( json_encode( $ct ) );
print ( $result );
print "\n";
