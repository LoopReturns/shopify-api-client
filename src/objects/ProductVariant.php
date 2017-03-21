<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace RocketCode\Shopify\Objects;
use \RocketCode\Shopify\Exceptions\ShopifyException;

class ProductVariant extends BaseObject {

	use \RocketCode\Shopify\Traits\ShopifyTransport;

	protected $name = "variants";
	protected $key = "variant";

	protected $omit = [ 'update', 'create' ];
	protected $parent = "products";
	protected $hasParent = [ 'all', 'count', 'create', 'delete' ];

	public function findByProduct( $args ) {
		if( !array_key_exists( 'product_id', $args ) ) {
			throw new ShopifyException( 'Invalid args: provide a product id' );
		}

		$internalArgs = $args;
		$internalArgs['parent_id'] = $args['product_id'];
		unset( $internalArgs['product_id'] );

		return $this->all( $internalArgs );
	}

}