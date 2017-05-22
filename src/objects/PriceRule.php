<?php
/**
 * User: bschmidt
 * Date: 5/18/17
 */
namespace Xariable\Shopify\Objects;

class PriceRule extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "price_rules";
	protected $key = "price_rule";
}
