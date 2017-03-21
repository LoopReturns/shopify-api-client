<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace RocketCode\Shopify\Objects;

use \RocketCode\Shopify\Exceptions\ShopifyException;

class Product extends BaseObject {

	use \RocketCode\Shopify\Traits\ShopifyTransport;

	protected $name = "products";
	protected $key = "product";
	
}