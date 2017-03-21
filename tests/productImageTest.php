<?php

//var_dump( $_ENV );

require_once 'vendor/autoload.php';

putenv('SHOP_API_KEY=57ce0f2a615c348e7e703f8e44f010e8');
putenv('SHOP_API_PASSWORD=0f27e5fc5c0d9341b545e4f3b22d5d0f');
putenv('SHOP_DOMAIN=brandon-development-store.myshopify.com');

$sc = new RocketCode\Shopify\Client;

print "Class of ( sc ) : " . get_class( $sc );
print "\n";

$product = $sc::ProductImage();

print "Class of ( product ) : " . get_class( $product );
print "\n";

$product_id = "2097873795";

$prod = $product->all( array( 'parent_id' => $product_id ) );
var_dump($prod);

$prod2 = $product->all(
	array(  'parent_id' => $product_id,
			'fields' => array( 'id','title')
) );
var_dump( $prod2 );


$product = $sc::ProductImage();
$count =$product->count( array( 'parent_id' => $product_id ) );
var_dump($count);