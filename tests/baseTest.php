<?php

//var_dump( $_ENV );

require_once 'vendor/autoload.php';

putenv('SHOP_API_KEY=57ce0f2a615c348e7e703f8e44f010e8');
putenv('SHOP_API_PASSWORD=0f27e5fc5c0d9341b545e4f3b22d5d0f');
putenv('SHOP_DOMAIN=brandon-development-store.myshopify.com');

$sc = new RocketCode\Shopify\Client($key);

print "Class of ( sc ) : " . get_class( $sc );
print "\n";

$product2 = $sc::Product(['idnex' => 'tessting']);

print "Class of ( product2 ) : " . get_class( $product2 );
print "\n";

$product_id = "2097873795";

$prod = $product2->find( array( 'id' => $product_id ) );
var_dump($prod);

$prod2 = $product2->find(
	array(  'id' => $product_id,
			'fields' => array( 'id','handle','title')
) );
// var_dump( $prod2 );

$prod3 = $product2->count(
	array(
		'filters' => array(
			'collection_id' => '157528323',
		)
	)
);
var_dump( $prod3 );

$prod4 = $product2->count();
var_dump( $prod4 );

$prod5 = $product2->count(
	array(
		'filters' => array(
			'collection_id' => '157528323',
			'vendor' => 'Brandon Development Store',
			'updated_at_min' => '2016-05-10',
		)
	)
);
var_dump( $prod5 );

$npd = new stdClass;
$npd->title = "Burton Custom Freestlye 151";
$npd->vendor = "Test Store";
$npd->product_type = "Throw Away";
$npd->published = "false";

$prod6 = $product2->create( json_encode( $npd ) );
var_dump( $prod6 );

$prod6Obj = json_decode( $prod6 );
$id = $prod6Obj->id;
print "ID: " . $prod6Obj->id . "\n";

$prod8 = $product2->find( array( 'id' => $id ) );
print $prod8;
print "\n";
var_dump( $prod8 );

$p8Obj = json_decode( $prod8 );
$p8Obj->title = "Updated Stuff";
print "Before update.";
var_dump($p8Obj);

$prod8 = $product2->update( json_encode( $p8Obj ) );
print "After update.";
var_dump( $prod8 );

$prod7 = $product2->delete( array( 'id' => $id ) );
var_dump( $prod7 );

try {
	$prod8 = $product2->delete();
	var_dump($prod8);
}
catch( RocketCode\SHopify\Exceptions\ShopifyException $e ) {
	print "Derpy: {$e->getMessage()}\n";
}
