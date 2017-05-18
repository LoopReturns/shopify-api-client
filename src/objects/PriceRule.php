<?php
/**
 * User: bschmidt
 * Date: 5/18/17
 */
namespace RocketCode\Shopify\Objects;

class PriceRule extends BaseObject {

	use \RocketCode\Shopify\Traits\ShopifyTransport;

	protected $name = "price_rules";
	protected $key = "price_rule";
}
