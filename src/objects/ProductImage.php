<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;
use \Xariable\Shopify\Exceptions\ShopifyException;

class ProductImage extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "images";
	protected $key = "image";
	protected $parent = "products";
	protected $omit = [];

	/*
	// GET products/#{id}/images.json
	// Receive a list of all Product Images
	public function get($args) {
		if( !array_key_exists( 'product_id', $args ) ) {
			throw new ShopifyException( 'Invalid args: provide a product id' );
		}

		$url = $this->getShopBaseUrl() . "products/{$args['product_id']}/images.json";

		if( array_key_exists( 'fields', $args ) )
			$url .= "?fields=" . implode( ',', $args['fields'] );

		$result = $this->execute( $url, "GET" );
		$result = json_decode( $result );

		if( $result and property_exists($result,'images') ) {
			return json_encode($result->images);
		}

		return $result;
	}


	// GET products/#{id}/images/count.json
	// Receive a count of all Product Images
	public function count( $args=array() ) {
		if( !array_key_exists( 'product_id', $args ) ) {
			throw new ShopifyException( 'Invalid args: provide a product id' );
		}

		$url = $this->getShopBaseUrl() . "products/{$args['product_id']}/images/count.json";

		if( array_key_exists( 'filters', $args ) ) {
			$filterArray = array();
			foreach( $args['filters'] as $k => $v ) {
				$filterArray[] = "{$k}={$v}";
			}
			$url .= "?" . implode( '&', $filterArray );
		}
		return $this->execute( $url, "GET" );
	}
	*/

}
