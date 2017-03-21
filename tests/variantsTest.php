<?php

//var_dump( $_ENV );

require_once 'vendor/autoload.php';

putenv('SHOP_API_KEY=57ce0f2a615c348e7e703f8e44f010e8');
putenv('SHOP_API_PASSWORD=0f27e5fc5c0d9341b545e4f3b22d5d0f');
putenv('SHOP_DOMAIN=brandon-development-store.myshopify.com');

$sc = new RocketCode\Shopify\Client;

print "Class of ( sc ) : " . get_class( $sc );
print "\n";

$product2 = $sc::ProductVariant();

print "Class of ( product2 ) : " . get_class( $product2 );
print "\n";

$product_id = "2097873795";

$prod = $product2->findByProduct( array( 'product_id' => $product_id ) );
var_dump($prod);

$prod2 = $product2->findByProduct(
	array(  'product_id' => $product_id,
			'fields' => array( 'id','title')
) );
var_dump( $prod2 );


$variant_id = '603824851';
$prod = $product2->find( array( 'id' => $variant_id ) );
var_dump($prod);