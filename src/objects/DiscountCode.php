<?php
/**
 * User: bschmidt
 * Date: 5/18/17
 */
namespace RocketCode\Shopify\Objects;

class DiscountCode extends BaseObject {

	use \RocketCode\Shopify\Traits\ShopifyTransport;

	## Need to customize enable/disable.

	protected $name = "discount_codes";
	protected $key = "discount_code";
	protected $parent = "price_rules";
}
